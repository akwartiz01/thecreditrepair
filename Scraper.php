<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \GuzzleHttp\Client;

class Scraper extends MY_Controller
{
    private $LOGIN_URL = "https://member.identityiq.com/login.aspx";
    private $SECURITY_Q_URL = "https://member.identityiq.com/SecurityQuestions.aspx";

    private $DOM;
	private $USER;
	private $PASSWORD;
	private $CODE;
    private $CLIENTID;
    private $REPORT_CONTENT;

	public function index()
    {
    	
		$this->load->helper(array('form', 'url'));
    	$this->load->library('form_validation');

    	$this->form_validation->set_rules('username','Username', 'required');
    	$this->form_validation->set_rules('passwd','Password', 'required');
    	$this->form_validation->set_rules('code','Security Code', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('scraper');
            //redirect(base_url().'import_audit/'.get_encoded_id($ClientID));
		}
		else
		{
				/*$this->USER = $this->input->post("username");
				$this->PASSWORD = $this->input->post("passwd");
				$this->CODE = $this->input->post("code");*/
                $this->CLIENTID = $this->input->post("clientid");
                $this->REPORT_CONTENT = $this->input->post("report_content");
                echo $this->CLIENTID;
				//$this->start();
		}
    }

    public function start($username, $password, $code)
    {
        //die('dddf');
        $this->DOM = new DOMDocument();
        $this->USER = $username;
        $this->PASSWORD = $password;
        $this->CODE = $code;

		$client = new GuzzleHttp\Client(["cookies" => true]);

        # 1. Set up login options
        $simple_options = $this->get_login_options();
        
        # 2. Get login page
        $login_response = $client->request('GET', $this->LOGIN_URL, $simple_options);

        # 3. Clean body html error
		$cleaned_body = $this->clean_body_html($login_response);
        
        # 4. Prepare data for login
        $post_login_options = $this->get_post_login_options($cleaned_body);
        
        # 5. Do login
        $after_login = $client->request("POST", $this->LOGIN_URL, $post_login_options);
        
        # 6. Get security question page
        $security_page = $client->request("GET", $this->SECURITY_Q_URL, $simple_options);
        
        # 7. Prepare options to post for security question */
        $security_q_options = $this->get_post_sec_q_options($security_page);
        
        $after_security_q = $client->request("POST", $this->SECURITY_Q_URL, $security_q_options);
        
        $report_page = $client->request("get", "https://member.identityiq.com/CreditReport.aspx", $simple_options);
        $body = (string) $report_page->getBody();

        /*
         * Got everything from the server
         */

		###############################################

		/*
		 * Alter to make it run inside CI server
		 */

        # 1. Correction of assets
		$body_href_correction = str_replace("href=\"", "href=\"https://member.identityiq.com", $body);
		$body_src_correction = str_replace("src=\"/", "src=\"https://member.identityiq.com/", $body_href_correction);

		# 2. Inject custom script

		$body_js_included = str_replace("</form>",
			"</form><script src='".base_url()."assets-scrap/js/scraper.js' type='text/javascript'> </script>",
			$body_src_correction
		);

        # 3. Replace "script.DEFAULT.js" URL with the local URL

		$final_body = str_replace(
			"https://member.identityiq.com/CreditReportContent/DEFAULT/script.DEFAULT.js",
			base_url()."assets-scrap/js/script.DEFAULT.js",
			$body_js_included
		);

		$data["res"] = $final_body;
        $this->load->view("report", $data);

  
    }

       
    protected function get_login_options(){
        
        $headers = [
            "Accept" => "*/*",
            "Accept-Language" => "fr-FR,fr;q=0.9",
            "Connection" => "keep-alive",
            "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36",
        ];

        $options["allow_redirects"] = true;
        $options["verify"] = false;

        $options["headers"] = $headers;

        return $options;
    }

    protected function clean_body_html($res){
        $body = (string) $res->getBody();
		return str_replace("></link>", "/>", $body);
    }

    protected function get_post_login_options($cleaned){

		$this->DOM->loadHTML($cleaned);
        
        $xpath = new DOMXPath($this->DOM);
        $elements = $xpath->query("//input");
        
        // Get hidden inputs
        $options['form_params'] = [
            'ScriptManager1' => 'Panel|imgBtnLogin',
            '__EVENTTARGET' => '',
            '__EVENTARGUMENT' => '',
            '__VIEWSTATE' => '',
            '__VIEWSTATEGENERATOR' => '',
            "__EVENTVALIDATION" => "",
            "__ASYNCPOST" => "true",
            "imgBtnLogin" => "LOGIN"
        ];

        foreach ($elements as $el) {
            $value = $el->getAttribute("value");
            $name = $el->getAttribute("name");
            $options["form_params"][$name] = $value;
        };
        

        // Append by username and password
        $options["form_params"]["txtUsername"] = $this->USER;
        $options["form_params"]["txtPassword"] = $this->PASSWORD;

        // Additional headers for post
		$headers = [
			"Accept" => "*/*",
			"Accept-Language" => "fr-FR,fr;q=0.9",
			"Connection" => "keep-alive",
			"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36",
		];
		$options["headers"] = $headers;
        $options["headers"]["X-MicrosoftAjax"] = "Delta=true";
        $options["headers"]["X-Requested-With"] = "XMLHttpRequest";
        $options["headers"]["Content-Type"] = "application/x-www-form-urlencoded; charset=UTF-8";
        $options["verify"] = false;
        return $options;
    }

    protected function get_post_sec_q_options($req){

        $options["allow_redirects"] = true;
        $options["verify"] = false;

        $cleaned_body = $this->clean_body_html($req);
        $new = str_replace("    </div>\r\n    </div>", "</div>", $cleaned_body);
        $this->DOM->loadHTML($new);
        
        $xpath = new DOMXPath($this->DOM);
        
        // Get hidden inputs
        $elements = $xpath->query("//input[@type='hidden']");

        foreach ($elements as $el) {
            $value = $el->getAttribute("value");
            $name = $el->getAttribute("name");
            $options["form_params"][$name] = $value;
        };
        

        // Append by sec id and sumbit button
        $password = $xpath->query("//input[@type='password']")[0];
        $password_name = $password->getAttribute("name");
        
        $submit = $xpath->query("//input[@type='submit']")[0];
        $submit_name = $submit->getAttribute("name");
        $submit_value = $submit->getAttribute("value");

        $options["form_params"][$password_name] = $this->CODE;
        $options["form_params"][$submit_name] = $submit_value;
                

        // Additional headers for post
        $options["headers"] = [
            "Accept" => "*/*",
            "Accept-Language" => "fr-FR,fr;q=0.9",
            "Connection" => "keep-alive",
            "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36",      
            "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
        ];
        return $options;
    }

     /*public function get_report_html(){

        $dd = '<script>';
        $dd .= 'var site = "http://member.identityiq.com/";';
        $dd .= 'var reportpageCnt = $("#divReprtOuter").clone()
        .find(".link_header,.moreAboutLink").remove().end()
        .find(".riskfactors").find("[ng-show="showDetail"]").remove().end()
        .find(".ng-hide").removeClass("ng-hide").end().end()
        .find("#reportUrl,#hdnRptContent").remove().end().html();';

        $dd .= 'reportpageCnt = reportpageCnt.replace(/src="\//ig, "src=\"" + site);';
        $dd .= '</script>';

        $mm = '<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>Credit Report - IdentityIQ </title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <link href="http://member.identityiq.com/CreditReportContent/DEFAULT/style.DEFAULT.css" rel="stylesheet" />
        <link href="http://member.identityiq.com/css/CRDownload.css" rel="stylesheet" />
        <script src="http://member.identityiq.com/Scripts/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="http://member.identityiq.com/Scripts/angular.js" type="text/javascript"></script>
        <script src="http://member.identityiq.com/Scripts/CRDownload.js" type="text/javascript" >
        </head>
        <body>';

        $mm .= 'var site = "http://member.identityiq.com/"; var reportpageCnt = $("#divReprtOuter").clone()
        .find(".link_header,.moreAboutLink").remove().end()
        .find(".riskfactors").find("[ng-show="showDetail"]").remove().end()
        .find(".ng-hide").removeClass("ng-hide").end().end()
        .find("#reportUrl,#hdnRptContent").remove().end().html(); reportpageCnt = reportpageCnt.replace(/src="\//ig, "src=\"" + site);';

        $mm .= '</body></html>';

        return $mm;

                
                
    }*/
}
