<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Furnishers extends MY_Controller
{

    function __construct()
    {

        parent::__construct();

        // redirect to sigin page if not logged in 

        if ($this->session->userdata('user_id') == '') {
            redirect(base_url());
            exit;
        }

        if ($this->session->userdata('user_type') == 'client') {
            redirect(base_url('client/dashboard'));
            exit;
        }

        // if ($this->session->userdata('user_type') == 'subscriber') {
        //     redirect(base_url('subscriber/dashboard'));
        //     exit;
        // }

        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->load->library('TCPDF');
    }


    public function furnisher()
    {
  if ($this->check_permisions("creditor", "view") != 1) {
            return false;
        }
        $comID = $this->input->post('comID');
        if ($comID != '') {

            $fetchdata = $this->User_model->select_where('sq_furnisher', array('id' => $comID));
            if ($fetchdata->num_rows() > 0) {
                $data['companyinfo_data'] = $fetchdata->result();
            }

            $fetchaddress = $this->User_model->select_where('sq_furnisher_address', array('ref_id' => $comID));
            if ($fetchaddress->num_rows() > 0) {
                $data['companyinfo_address'] = $fetchaddress->result();
            }
        }

        $fetchdata = $this->User_model->select_star('sq_furnisher');
        if ($fetchdata->num_rows() > 0) {
            $data['furnisher_data'] = $fetchdata->result();
        }

        $data['ss'] = '';
        $data['content'] = $this->load->view('furnisher/view', $data, true);
        $this->load->view('template/template', $data);
    }


    public function furnisher_ajax()
    {
        $request = $this->input->post();
        $columns = array(
            0 => 'company_name',
            1 => 'email'
            // 2 => 'phone'
        );
    
        $totalData = $this->db->count_all('sq_furnisher');
        $totalFiltered = $totalData;
    
        $this->db->from('sq_furnisher');
    
        // Search filter
        if (!empty($request['search']['value'])) {
            $this->db->group_start()
                ->like('company_name', $request['search']['value'])
                ->or_like('email', $request['search']['value'])
                ->or_like('phone', $request['search']['value'])
                ->group_end();
        }
    
        $totalFiltered = $this->db->count_all_results('', false);
    
        // Ordering
        if (isset($request['order'])) {
            $this->db->order_by($columns[$request['order'][0]['column']], $request['order'][0]['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    
        // Paging
        $this->db->limit($request['length'], $request['start']);
        $query = $this->db->get();
    
        $data = array();
        foreach ($query->result() as $row) {
            $data[] = array(
                'company_name' => $row->company_name,
                'email' => $row->email,
                // 'phone' => $row->phone,
               'actions' => '
                <a href="javascript:void(0);" onclick="deleteFurnisher('.$row->id.')" class="text-danger">
                    <i class="mdi mdi-delete"></i>
                </a>'

            );
        }
    
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    
        echo json_encode($json_data);
        exit;
    }
    


//  public function delete_furnisher()
//     {
//         $id = $this->input->post('id');
        
        
//         if ($id != '') {
//             $deleteTemplate = $this->User_model->query("SELECT * FROM sq_furnisher where $id = '" . $id . "' ")->first();
//             print_r($deleteTemplate);
//             // echo json_encode('deleted');
//         }
//     }
    
 public function delete_furnisher()
{
    $id = $this->input->post('id');

    if (!empty($id)) {
        // Optional: Get the row before deleting it (for confirmation)
        $template = $this->db->where('id', $id)->get('sq_furnisher')->row();

        if ($template) {
            $this->db->where('id', $id);
            $deleted = $this->db->delete('sq_furnisher');

            if ($deleted) {
                echo json_encode('deleted');
                // echo json_encode(['status' => 'success', 'message' => 'Furnisher deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Furnisher not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
    }
}


    public function submitData()
    {

        if (isset($_POST['submit'])) {

            $id             = $this->input->post('id');
            $add_id         = $this->input->post('add_id');
            $company_name   = $this->input->post('company_name');
            $email          = $this->input->post('email');
            $fax            = $this->input->post('fax');
            $address        = $this->input->post('address');
            $city           = $this->input->post('city');
            $state          = $this->input->post('state');
            $zip            = $this->input->post('zip');
            $pNumber        = $this->input->post('pNumber');
            $accounttype    = $this->input->post('accounttype');
            $notes          = $this->input->post('notes');

            $data['company_name']   = $company_name;
            $data['email']          = $email;
            $data['fax']            = $fax;
            $data['account_type']   = $accounttype;
            $data['notes']          = $notes;



            if ($id != '') {
                $this->User_model->updatedata('sq_furnisher', array('id' => $id), $data);
                $lastID = $id;
            } else {

                $chkCompany = $this->User_model->select_where('sq_furnisher', array('company_name' => $company_name));
                if ($chkCompany->num_rows() > 0) {

                    $this->session->set_flashdata('error', 'Company name already exist.');
                    redirect(base_url() . 'furnisher');
                } else {

                    $this->User_model->insertdata('sq_furnisher', $data);
                    $lastID = $this->db->insert_id();
                }
            }

            foreach ($address as $key => $value) {
                if ($value != '') {

                    if ($add_id[$key] != '') {

                        $this->User_model->query("UPDATE `sq_furnisher_address` SET `address`='" . $value . "', `city`='" . $city[$key] . "', `state`='" . $state[$key] . "', `zip`='" . $zip[$key] . "', `phone`='" . $pNumber[$key] . "' WHERE id='" . $add_id[$key] . "' ");
                    } else {

                        $this->User_model->query("INSERT INTO `sq_furnisher_address`(`ref_id`, `address`, `city`, `state`, `zip`, `phone`) VALUES ('" . $lastID . "', '" . $value . "', '" . $city[$key] . "', '" . $state[$key] . "', '" . $zip[$key] . "', '" . $pNumber[$key] . "' )");
                    }
                }
            }

            $this->session->set_flashdata('success', 'Furnisher data submit successfully');
            $this->allActivity('Furnisher data saved successfully!'); //track activity
            redirect(base_url() . 'furnisher');
        }
    }

    public function import_csv()
    {

        if (isset($_POST['import'])) {

            if ($_FILES['csvfile']['name'] != '') {

                $filename = $_FILES['csvfile']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if ($ext == 'csv') {

                    $path = 'documents/' . $filename;
                    if (move_uploaded_file($_FILES['csvfile']['tmp_name'], $path)) {

                        $fileNames = base_url() . 'documents/' . $filename;
                        $file = fopen($fileNames, "r");
                        $count = 0;

                        while (($milestone = fgetcsv($file, 1000, ",")) !== FALSE) {
                            $count++;
                            if ($count > 1) {

                                $furnisher_data = array(
                                    'company_name'      =>   $milestone[0],
                                    'account_type'      =>   $milestone[6],
                                    'notes'             =>   $milestone[7],
                                );

                                $chkCompany = $this->User_model->select_where('sq_furnisher', array('company_name' => $milestone[0]));
                                if ($chkCompany->num_rows() > 0) {

                                    $chkCompany = $chkCompany->result();
                                    $lastID = $chkCompany[0]->id;

                                    $chkaddres = $this->User_model->select_where('sq_furnisher_address', array('address' => $milestone[1], 'city' => $milestone[2], 'state' => $milestone[3], 'zip' => $milestone[4], 'phone' => $milestone[5], 'ref_id' => $lastID));
                                    if ($chkaddres->num_rows() > 0) {
                                        //nothing to do
                                    } else {

                                        $this->User_model->query("INSERT INTO `sq_furnisher_address`(`ref_id`, `address`, `city`, `state`, `zip`, `phone`) VALUES ('" . $lastID . "','" . $milestone[1] . "','" . $milestone[2] . "','" . $milestone[3] . "','" . $milestone[4] . "','" . $milestone[5] . "' )");
                                    }
                                } else {

                                    $this->User_model->insertdata('sq_furnisher', $furnisher_data);
                                    $lastID = $this->db->insert_id();

                                    $this->User_model->query("INSERT INTO `sq_furnisher_address`(`ref_id`, `address`, `city`, `state`, `zip`, `phone`) VALUES ('" . $lastID . "','" . $milestone[1] . "','" . $milestone[2] . "','" . $milestone[3] . "','" . $milestone[4] . "','" . $milestone[5] . "' )");
                                }
                            }
                        }
                        exit();
                        unlink($filename);
                        $this->session->set_flashdata('error', 'All data imported successfully');
                        redirect(base_url() . 'furnisher');
                    } else {
                        $this->session->set_flashdata('error', 'File not uploaded');
                        redirect(base_url() . 'furnisher');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Choose an CSV file.');
                    redirect(base_url() . 'furnisher');
                }
            } else {

                $this->session->set_flashdata('error', 'Choose an CSV file.');
                redirect(base_url() . 'furnisher');
            }
        }
    }

    public function export_csv()
    {

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="furnisher_' . date('m-d-Y') . '.csv";');

        $f = fopen("php://output", "w");
        fputcsv($f, array('Company Name', 'Address', 'City', 'State', 'Zip', 'Phone', 'Account Type', 'Notes')); // title...

        $fetchdata = $this->User_model->query("SELECT * FROM `sq_furnisher` as sf JOIN sq_furnisher_address as sfa ON sf.id = sfa.ref_id ");
        if ($fetchdata->num_rows() > 0) {
            $companyinfo_data = $fetchdata->result();

            foreach ($companyinfo_data as $row) {

                $output['company_name'] = $row->company_name;
                $output['address'] = $row->address;
                $output['city'] = $row->city;
                $output['state'] = $row->state;
                $output['zip'] = $row->zip;
                $output['phone'] = $row->phone;
                $output['account_type'] = $row->account_type;
                $output['notes'] = $row->notes;

                fputcsv($f, $output);
            }
        }

        fclose($f);
        exit();
    }
}
