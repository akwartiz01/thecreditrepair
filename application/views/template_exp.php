<div ng-show="!isLoaded">
    Loading.. please wait
</div>
<div ng-if="isLoaded&&valid">
    <div class="rpt_content_wrapper" id="reportTop">
        <div class="link_header">
            <div style="float:left;font-size:11px;" ng-if="reportHistory&&reportHistory.length>1">
                Report History:
                <select name="ddlReportHistory" class="user-select" style="font-size: 11px; width: inherit !important;
                    height: 18px;" ng-model="selectedHistory" ng-options="hry.Id as hry.Date for hry in reportHistory track by hry.Id"
                        ng-change="reportHistoryChanged()"></select>
            </div>
            <a href="javascript:void(0);" style="text-decoration: none; color: #333; display: none;"
               class="aPrintLoader">Loading..</a><a class="imgPrintAction" href="javascript:void(0);"
                                                    onclick="return PrintPage()">
                <img src="/images/tu/print_icon.gif">Print this page
            </a>
            <div style="display:inline-block;width:190px;">
                <a href="javascript:void(0);"
                   style="text-decoration: none; color: #333; display: none;" class="aDownloadLoader">
                    Loading..
                </a><a class="imgDownloadAction" href="javascript:void(0);" onclick="downloadCreditReport()">
                    <img src="/images/tu/download.jpg" />Download this report
                </a>
            </div>
        </div>
        <div class="reportTopHeader" ng-show="is3B">
            Three Bureau Credit Report
        </div>
        <div class="reportTopHeader" ng-show="!is3B">
            One Bureau Credit Report
        </div>

        {{ TUC = reports["TUC"];""}}{{EXP = reports["EXP"];""}}{{EQF = reports["EQF"];""}}
        <table id="reportTop" class="reportTop_content">
            <tr>
                <td class="label" style="width: 15%; text-align: right">
                    Reference #
                </td>
                <td style="width: 35%;">
                    {{referenceNo}}
                </td>
                <td style="width: 20%; text-align: right" class="label">
                    Report Date:
                </td>
                <td style="width: 15%;">
                    <ng ng-if="EXP.report_date">
                        {{EXP["report_date"]|dateIgnoreTimezone:'MM/dd/yyyy'}}
                    </ng>
                </td>
            </tr>
        </table>
        <div class="link_header" style="padding-bottom: 0px;">
            <span style="font-size: 85%; font-weight: bold">Quick Links:</span>&nbsp;<a href="javascript:void(0);"
                                                                                        id="TopCreditScore" ng-click="scrollTo('CreditScore')" target="_self">Credit&nbsp;Score</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopSummary" ng-click="scrollTo('Summary')" target="_self">Summary</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopAccountHistory" ng-click="scrollTo('AccountHistory')"
                                                                                                                                                                                                                                                                                                                       target="_self">Account History</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopInquiries" ng-click="scrollTo('Inquiries')"
                                                                                                                                                                                                                                                                                                                                                                         target="_self">Inquiries</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopCreditorContacts"
                                                                                                                                                                                                                                                                                                                                                                                                                     ng-click="scrollTo('CreditorContacts')" target="_self">
                Creditor Contacts
            </a>
            <!--/ <a href="javascript:void(0);" ng-click="scrollTo('PublicInformation')"
                            target="_self">Public Information</a>-->
        </div>
    </div>
    <!--source: crBorrower.xls-->
    <!--PersonInfo start-->
    <!--source: crBorrower.xls-->
    <!--source: crBorrower.xls-->
    {{ message = reports.Message;""}} {{
 Frozen = reports.SB168Frozen;""
    }}
    <div ng-if="Frozen['@transunion']=='true'||Frozen['@experian']=='true'||Frozen['@equifax']=='true'">
        <table class="help_text" style="border: solid 1px #dfdfdf; margin-top: 10px;">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/warning-icon.png">
                    </td>
                    <td>
                        <font color="red" size="2"><b>***SECURITY FREEZE: </b></font>THE FOLLOWING CREDIT
                        BUREAUS REPORT THAT YOU HAVE PLACED A SECURITY FREEZE OR LOCK ON THIS FILE. HOWEVER,
                        THE FILE HAS BEEN DELIVERED TO YOU UNDER THE APPLICABLE EXEMPTION PROVISIONS &#40;PROVIDING
                        A CONSUMER WITH A COPY OF HIS OR HER CREDIT REPORT UPON THE CONSUMER'S REQUEST&#41;:<br />
                        <b>
                            <span ng-if="Frozen['@transunion']=='true'" class="tranUnionClr">TRANSUNION</span>
                            <ng-if ng-if="Frozen['@experian']=='true'||Frozen['@equifax']=='true'">, </ng-if>
                            <span ng-if="Frozen['@experian']=='true'" class="experianClr">EXPERIAN</span>
                            <ng-if ng-if="Frozen['@equifax']=='true'">, </ng-if>
                            <span ng-if="Frozen['@equifax']=='true'" class="equifaxClr">EQUIFAX</span>
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="content_divider">
        </div>
    </div>
    <!--<ng-repeat ng-repeat="msg in message">
        <table border="0" cellpadding="0" class="tbl-tu-report tbl-tu-borderd" cellspacing="0" ng-if="msg.Code['@symbol']=='XE010'">
            <tr>
                <td font-family=" verdana">
                    <font color="red" size="2">
                        THE FOLLOWING CREDIT BUREAUS REPORT THAT FOR PRIVACY PURPOSES, WE CANNOT
                        DISPLAY A MINOR'S CREDIT REPORT ONLINE: <b>EXPERIAN</b>
                        <br />
                    </font>
                </td>
            </tr>
        </table>
    </ng-repeat>--> 
    <div ng-show="consumer_statements['TUC'].length>0 || consumer_statements['EXP'].length>0 || consumer_statements['EQF'].length>0">
        <div class="rpt_content_wrapper">
            <div class="rpt_fullReport_header" style="display: block;">
                Customer Statement
            </div>
            <table class="rpt_content_table rpt_content_header rpt_content_contacts extra_info">
                <tr ng-show="{{is3B}}">
                    <td style="width: 25%;" class="tuc_header">
                        TransUnion:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <ng-repeat ng-repeat="stmt in stmsts=consumer_statements['TUC']">
                            {{stmt["statement"]|trim}}
                        </ng-repeat>
                        <ng ng-show="stmsts.length==0">-</ng>
                    </td>
                </tr>
                <tr class="rowAlt">
                    <td style="width: 25%;" class="exp_header">
                        Experian:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <ng-repeat ng-repeat="stmt in stmsts=consumer_statements['EXP']">
                            {{stmt["statement"]|trim}}
                        </ng-repeat>
                        <ng ng-show="stmsts.length==0">-</ng>
                    </td>
                </tr>
                <tr ng-show="{{is3B}}">
                    <td style="width: 25%;" class="eqf_header">
                        Equifax:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <ng-repeat ng-repeat="stmt in stmsts=consumer_statements['EQF']">
                            {{stmt["statement"]|trim}}
                        </ng-repeat>
                        <ng ng-show="stmsts.length==0">-</ng>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content_divider">
        </div>
    </div>
    <script type="text/ng-template" id="personNameTemplate">
        <ng-if ng-if="person['first_name']|trim">
            {{person["first_name"]|trim}}&#xA0;
        </ng-if>
        <ng-if ng-if="person['middle_name']|trim">
            {{person["middle_name"]|trim}}&#xA0;
        </ng-if>
        <ng-if ng-if="person['last_name']">
            {{person["last_name"]}}
        </ng-if>
    </script>
    <script type="text/ng-template" id="addressTemplate">

        {{addressLine = combineAddressLine(addr);""}}
        <ng-if ng-if="addressLine">
            {{addressLine}}<br />
        </ng-if>
        <ng-if ng-if="(addr['city']|trim) || (addr['state']|trim)">
            {{addr['city']|trim}},&#xA0;{{addr['state']|trim}}<br />
        </ng-if>
        <ng-if ng-if="addr['zipcode']">
            {{addr['zipcode']|zipcode}}
        </ng-if>
    </script>
    <script type="text/ng-template" id="scoreRiskFactorText">
        <ng ng-if="factor['is_positive'] =='False'">
            {{ factorCode = removeLeadingZeros(factor['code']);""}}
            {{ showDetail = scoreFactorNegativeShortDesc[factorCode];""}}
            <ng-if ng-show="showDetail">
                <b>{{scoreFactorNegativeShortDesc[factorCode]}}.</b>
                <a style="text-decoration: none" href="#" ng-click="show=(!showDetail||!show)">
                    <ng ng-show="show">[-]</ng>
                    <ng ng-show="!show">[+]</ng>
                </a>
                <div ng-show="show">
                    <span>{{scoreFactorNegativeDetailedDesc[factorCode]}} </span>
                </div>
            </ng-if>
            <ng-if ng-show="!showDetail">
                <b ng-if='scoreFactorNegativeShortDesc[factorCode]'>{{scoreFactorNegativeShortDesc[factorCode]}}.</b>
                <div>{{scoreFactorNegativeDetailedDesc[factorCode]}} </div>
            </ng-if>
        </ng>
    </script>
    <div class="rpt_content_wrapper">
        <div class="rpt_fullReport_header" style="display: block;">
            Personal Information
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below is your personal information as it appears in your credit file. This information
                        includes your legal name, current and previous addresses, employment information
                        and other details.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC" ng-show="{{is3B}}">
                    TransUnion
                </th>
                <th class="headerEXP">
                    Experian
                </th>
                <th class="headerEQF" ng-show="{{is3B}}">
                    Equifax
                </th>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Credit Report Date:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-show="TUC.report_date">
                        {{TUC["report_date"]|dateIgnoreTimezone:'MM/dd/yyyy'}}
                    </ng-repeat>
                    <ng ng-show="!TUC.report_date">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-show="EXP.report_date">
                        {{EXP["report_date"]|dateIgnoreTimezone:'MM/dd/yyyy'}}
                    </ng-repeat>
                    <ng ng-show="!EXP.report_date">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-show="EQF.report_date">
                        {{EQF["report_date"]|dateIgnoreTimezone:'MM/dd/yyyy'}}
                    </ng-repeat>
                    <ng ng-show="!EQF.report_date">-</ng>
                </td>
            </tr>
            {{ TUCNames = makeArray(TUC.names);"" }}{{ EXPNames = makeArray(EXP.names);"" }}  {{ EQFNames = makeArray(EQF.names);"" }}
               <tr>
                <td class="label">
                    Name:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in TUCNames" ng-if="$index == 0">
                        <div>
                            <ng-include src=" 'personNameTemplate' " onload=" person=name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="TUCNames.length==0">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="name in EXPNames" ng-if="$index == 0">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EXPNames.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in EQFNames" ng-if="$index == 0">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EQFNames.length==0">-</ng>
                </td>
            </tr>             
            <tr class="rowAlt">
                <td class="label">
                    Also Known As:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in TUCNames" ng-if="$index > 0">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="TUCNames.length<=1">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="name in EXPNames" ng-if="$index > 0">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EXPNames.length<=1">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in EQFNames" ng-if="$index > 0">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EQFNames.length<=1">-</ng>
                </td>
            </tr>
            {{ TUCNamesFormer = makeArray(TUC.names_former);"" }}{{ EXPNamesFormer = makeArray(EXP.names_former);"" }}  {{ EQFNamesFormer = makeArray(EQF.names_former);"" }}
            <tr class="rowAlt">
                <td class="label">
                    Former:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in TUCNamesFormer">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="TUCNamesFormer.length==0">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="name in EXPNamesFormer">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EXPNamesFormer.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in EQFNamesFormer">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EQFNamesFormer.length==0">-</ng>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Date of Birth:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-show="TUC.year_of_birth">
                        <div>
                            {{TUC.year_of_birth}}
                        </div>
                    </ng-repeat>
                    <ng ng-show="!TUC.year_of_birth">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-show="EXP.year_of_birth">
                        <div>
                            {{EXP.year_of_birth}}
                        </div>
                    </ng-repeat>
                    <ng ng-show="!EXP.year_of_birth">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-show="EQF.year_of_birth">
                        <div>
                            {{EQF.year_of_birth}}
                        </div>
                    </ng-repeat>
                    <ng ng-show="!EQF.year_of_birth">-</ng>
                </td>
            </tr>
            {{ TUCAddresses = makeArray(TUC.addresses);"" }}{{ EXPAddresses = makeArray(EXP.addresses);"" }}  {{ EQFAddresses = makeArray(EQF.addresses);"" }}
            <tr class="rowAlt">
                <td class="label">
                    Current Address(es):
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tucAddr in TUCAddresses" ng-if="$index == 0">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = tucAddr"></ng-include>
                            <div ng-if="(tucAddr['date_last_updated']||tucAddr['date_first_reported']).indexOf('1900-01')==-1">
                                {{(tucAddr['date_last_updated']||tucAddr['date_first_reported'])|dateIgnoreTimezone:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="TUCAddresses.length==0">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="expAddr in EXPAddresses" ng-if="$index == 0">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = expAddr"></ng-include>
                            <div ng-if="(expAddr['date_last_updated']||expAddr['date_first_reported']).indexOf('1900-01')==-1">
                                {{(expAddr['date_last_updated']||expAddr['date_first_reported'])|dateIgnoreTimezone:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EXPAddresses.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="eqfAddr in EQFAddresses" ng-if="$index == 0">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = eqfAddr"></ng-include>
                            <div ng-if="(eqfAddr['date_last_updated']||eqfAddr['date_first_reported']).indexOf('1900-01')==-1">
                                {{(eqfAddr['date_last_updated']||eqfAddr['date_first_reported'])|dateIgnoreTimezone:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EQFAddresses.length==0">-</ng>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Previous Address(es):
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tucAddr in TUCAddresses" ng-if="$index > 0">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = tucAddr"></ng-include>
                            <div ng-if="(tucAddr['date_last_updated']||tucAddr['date_first_reported']).indexOf('1900-01')==-1">
                                {{(tucAddr['date_last_updated']||tucAddr['date_first_reported'])|dateIgnoreTimezone:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="TUCAddresses.length<=1">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="expAddr in EXPAddresses" ng-if="$index > 0">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = expAddr"></ng-include>
                            <div ng-if="(expAddr['date_last_updated']||expAddr['date_first_reported']).indexOf('1900-01')==-1">
                                {{(expAddr['date_last_updated']||expAddr['date_first_reported'])|dateIgnoreTimezone:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EXPAddresses.length<=1">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="eqfAddr in EQFAddresses" ng-if="$index > 0">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = eqfAddr"></ng-include>
                            <div ng-if="(eqfAddr['date_last_updated']||eqfAddr['date_first_reported']).indexOf('1900-01')==-1">
                                {{(eqfAddr['date_last_updated']||eqfAddr['date_first_reported'])|dateIgnoreTimezone:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="EQFAddresses.length<=1">-</ng>
                </td>
            </tr>
            {{ TUCEmployers = makeArray(TUC.employers);"" }}{{ EXPEmployers = makeArray(EXP.employers);"" }}  {{ EQFEmployers = makeArray(EQF.employers);"" }}
            <tr class="rowAlt">
                <td class="label">
                    Employers:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="emp in TUCEmployers">
                        <div>
                            <ng-if ng-if="emp['name']|trim">
                                {{emp["name"]|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="emp['street_name']|trim">
                                {{emp['address']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="(emp['city']|trim) || (emp['state']|trim)">
                                {{emp['city']|trim}},&#xA0;{{emp['state']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="addr['zipcode']">
                                {{emp['zipcode']|zipcode}}
                            </ng-if>
                        </div>
                    </ng-repeat>
                    <ng ng-show="TUCEmployers.length==0">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="emp in EXPEmployers">
                        <div>
                            <ng-if ng-if="emp['name']|trim">
                                {{emp["name"]|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="emp['street_name']|trim">
                                {{emp['address']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="(emp['city']|trim) || (emp['state']|trim)">
                                {{emp['city']|trim}},&#xA0;{{emp['state']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="addr['zipcode']">
                                {{emp['zipcode']|zipcode}}
                            </ng-if>
                        </div>
                    </ng-repeat>
                    <ng ng-show="emps.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="emp in EQFEmployers">
                        <div>
                            <ng-if ng-if="emp['name']|trim">
                                {{emp["name"]|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="emp['street_name']|trim">
                                {{emp['address']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="(emp['city']|trim) || (emp['state']|trim)">
                                {{emp['city']|trim}},&#xA0;{{emp['state']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="addr['zipcode']">
                                {{emp['zipcode']|zipcode}}
                            </ng-if>
                        </div>
                    </ng-repeat>
                    <ng ng-show="emps.length==0">-</ng>
                </td>
            </tr>
            <!--<tr>
                <td class="label">
                    Consumer Comments:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="stmt in stmsts=(crdStmt|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{stmt["@statement"]|trim}}
                    </ng-repeat>
                    <ng ng-show="stmsts.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="stmt in stmsts=(crdStmt|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{stmt["@statement"]|trim}}
                    </ng-repeat>
                    <ng ng-show="stmsts.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="stmt in stmsts=(crdStmt|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{stmt["@statement"]|trim}}
                    </ng-repeat>
                    <ng ng-show="stmsts.length==0">-</ng>
                </td>
            </tr>-->
            <!--<tr class="rowAlt">
                <td class="label">
                    Fraud Alert:
                </td>
                <td class="info">
                    <ng-if ng-if="Frozen['@transunion']=='true'">

                    </ng-if>
                    <ng ng-show="Frozen['@transunion']=='false'">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-if ng-if="Frozen['@experian']=='true'">

                    </ng-if>
                    <ng ng-show="Frozen['@experian']=='false'">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-if ng-if="Frozen['@equifax']=='true'">

                    </ng-if>
                    <ng ng-show="Frozen['@equifax']=='false'">-</ng>
                </td>
            </tr>-->
        </table>
    </div>
    <div class="content_divider">
    </div>
    <!--PersonInfo end-->
    <!--credit score start-->
    <div class="rpt_content_wrapper">
        <div class="rpt_fullReport_header" id="CreditScore">
            <span class="return_topSpan">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                   target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon.gif">Back to Top
                </a>
            </span>Credit Score
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Your Credit Score is a representation of your overall credit health. Most lenders
                        utilize some form of credit scoring to help determine your credit worthiness.
                    </td>
                </tr>
            </tbody>
        </table>
        {{ TUCVantageScore = score_details.TUC;""}} {{ EXPVantageScore = score_details.EXP;""}}
        {{ EQFVantageScore = score_details.EQF;""}} {{ tucVScore= TUCVantageScore['score']|number;""}}
        {{ expVScore= EXPVantageScore['score']|number;""}} {{ eqfVScore= EQFVantageScore['score']|number;""}}
        {{ TUCFactors = TUCVantageScore.credit_score_factor?TUCVantageScore.credit_score_factor.factors:"";""}}
        {{ EXPFactors=EXPVantageScore.credit_score_factor?EXPVantageScore.credit_score_factor.factors:"";""}} {{EQFFactors=EQFVantageScore.credit_score_factor?EQFVantageScore.credit_score_factor.factors:"";""}}
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC" ng-show="{{is3B}}">
                    TransUnion
                </th>
                <th class="headerEXP">
                    Experian
                </th>
                <th class="headerEQF" ng-show="{{is3B}}">
                    Equifax
                </th>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Credit Score:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{ tucVScore<300?((tucVScore==1 || tucVScore==4) ?"Not Reported - Code: "+tucVScore:"Score Not Reported"):(tucVScore||"-")}}
                </td>
                <td class="info">
                    {{ expVScore<300?((expVScore==1 || expVScore==4) ?"Not Reported - Code: "+expVScore:"Score Not Reported"):(expVScore||"-")}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{ eqfVScore<300?((eqfVScore==1 || eqfVScore==4) ?"Not Reported - Code: "+eqfVScore:"Score Not Reported"):(eqfVScore||"-")}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Lender Rank:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{TUCVantageScore["score_rating"]||"-"}}
                </td>
                <td class="info">
                    {{EXPVantageScore["score_rating"]||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{EQFVantageScore["score_rating"]||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Score Scale:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    300-850
                </td>
                <td class="info">
                    300-850
                </td>
                <td class="info" ng-show="{{is3B}}">
                    300-850
                </td>
            </tr>
        </table>
        <div ng-show="(TUCFactors|| EXPFactors|| EQFFactors)">
            <div class="sub_header">
                Risk Factors
                <!--<a href="#" ng-click="showAllDescription(show);" style="float: right; color: #fff;">
                    <ng ng-show="show">hide all</ng>
                    <ng ng-show="!show">show all</ng>
                </a>-->
            </div>
            <table class="rpt_content_table rpt_content_header rpt_content_contacts extra_info riskfactors">
                <tr ng-show="{{is3B}}">
                    <td style="width: 25%;" class="tuc_header">
                        TransUnion:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <div ng-if="(tucVScore|number)>=300">
                            <div class="descriptionTxt" ng-repeat="factor in TUCFactors">
                                <ng-include src="'scoreRiskFactorText'" onload="factor = factor"></ng-include>
                            </div>
                            <ng ng-if="factors.length==0">-</ng>
                        </div>
                        <div ng-if="(tucVScore|number)<300">
                            <div class="descriptionTxt" ng-if="(tucVScore|number)!=1">
                                <b>There was not enough credit history available to generate a score.</b>
                            </div>
                            <div class="descriptionTxt" ng-if="(tucVScore|number)==1">
                                <b>Unable to generate score. Please contact the credit bureau for assistance.</b>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="rowAlt">
                    <td style="width: 25%;" class="exp_header">
                        Experian:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <div ng-if="(expVScore|number)>=300">
                            <div class="descriptionTxt" ng-repeat="factor in EXPFactors">
                                <ng-include src="'scoreRiskFactorText'" onload="factor = factor"></ng-include>
                            </div>
                            <ng ng-if="factors.length==0">-</ng>
                        </div>
                        <div ng-if="(expVScore|number)<300">
                            <div class="descriptionTxt" ng-if="(expVScore|number)!=1">
                                <b>There was not enough credit history available to generate a score.</b>
                            </div>
                            <div class="descriptionTxt" ng-if="(expVScore|number)==1">
                                <b>Unable to generate score. Please contact the credit bureau for assistance.</b>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr ng-show="{{is3B}}">
                    <td style="width: 25%;" class="eqf_header">
                        Equifax:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <div ng-if="(eqfVScore|number)>=300">
                            <div class="descriptionTxt" ng-repeat="factor in EQFFactors">
                                <ng-include src="'scoreRiskFactorText'" onload="factor = factor"></ng-include>
                            </div>
                            <ng ng-if="factors.length==0">-</ng>
                        </div>
                        <div ng-if="(eqfVScore|number)<300">
                            <div class="descriptionTxt" ng-if="(eqfVScore|number)!=1">
                                <b>There was not enough credit history available to generate a score.</b>
                            </div>
                            <div class="descriptionTxt" ng-if="(eqfVScore|number)==1">
                                <b>Unable to generate score. Please contact the credit bureau for assistance.</b>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="info" style="line-height: 18px;">
                        <div class="descriptionTxt">
                            <p>
                                The score(s) on your IdentityIQ credit report (using the VantageScore® 3.0 model)
                                are provided as a tool to help you understand how lenders may view the data contained
                                in your credit reports and evaluate your credit risk. We provide these scores solely
                                for educational purposes. IdentityIQ does not offer credit; delivery of these scores
                                does not qualify you for any loan. The scoring model your lender uses may be different
                                than the VantageScore® 3.0. As a result, the score and score factors we
                                have delivered may show differences when compared to the score and score factors
                                produced by your lender's scoring model. Please also understand that lenders use
                                multiple sources of information when underwriting a loan and making lending decisions.
                                Credit scores are just one factor that may be used and each lender will have different
                                criteria they consider.
                            </p>
                            <p>
                                IdentityIQ provides informational materials along with your credit report(s) and
                                score(s) these materials are educational in nature and intended to broaden your
                                understanding of how credit scoring works. They should not be construed as advice
                                in handling your financial problems or making financial decisions. If you are having
                                trouble keeping up with your bill payments or experiencing other financial difficulties,
                                please contact a non-profit credit counseling service for assistance. These materials
                                are for educational purposes only.
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="content_divider">
    </div>
    <!--credit score end-->
    <!--Summary starts-->
    <div class="rpt_content_wrapper">
        <div class="rpt_fullReport_header" id="Summary">
            <span class="return_topSpan">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                   target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon.gif">Back to Top
                </a>
            </span>Summary
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below is an overview of your present and past credit status including open and closed
                        accounts and balance information.
                    </td>
                </tr>
            </tbody>
        </table> 
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC" ng-show="{{is3B}}">
                    TransUnion
                </th>
                <th class="headerEXP">
                    Experian
                </th>
                <th class="headerEQF" ng-show="{{is3B}}">
                    Equifax
                </th>
            </tr>
           
            <tr class="rowAlt">
                <td class="label">
                    Total Accounts:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['total_count'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['total_count'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['total_count'])||"-"}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Open Accounts:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['open_count'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['open_count'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['open_count'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Closed Accounts:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['closed_count'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['closed_count'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['closed_count'])||"-"}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Delinquent:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['delinquent'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['delinquent'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['delinquent'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Derogatory:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['derogatory'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['derogatory'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['derogatory'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Collection:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['collection'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['collection'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['collection'])||"-"}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Balances:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['balance']|currencyIgnoreEmpty)||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['balance']|currencyIgnoreEmpty)||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['balance']|currencyIgnoreEmpty)||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Payments:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <span class="Rsmall">
                        {{(account_summary['TUC']['payment']|currencyIgnoreEmpty)||"-"}}
                    </span>
                </td>
                <td class="info">
                    <span class="Rsmall">
                        {{(account_summary['EXP']['payment']|currencyIgnoreEmpty)||"-"}}
                    </span>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <span class="Rsmall">
                        {{(account_summary['EQF']['payment']|currencyIgnoreEmpty)||"-"}}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Public Records:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['public_record'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['public_record'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['public_record'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Inquiries(2 years):
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['TUC']['inquires'])||"-"}}
                </td>
                <td class="info">
                    {{(account_summary['EXP']['inquires'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(account_summary['EQF']['inquires'])||"-"}}
                </td>
            </tr>
        </table>
    </div>
    <div class="content_divider">
    </div>
    <!--Summary ends-->
    <!--Account history starts-->
    <script type="text/ng-template" id="tradeLinePartitionBasic">
        <div class="sub_header">
            {{tpartition['name']}}
            <ng ng-if="tpartition['original_creditor']">
                &nbsp;(Original Creditor: {{tpartition['original_creditor']}})
            </ng>
        </div>
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC" ng-show="{{is3B}}">
                    TransUnion
                </th>
                <th class="headerEXP">
                    Experian
                </th>
                <th class="headerEQF" ng-show="{{is3B}}">
                    Equifax
                </th>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Account #:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['number'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['number'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['number'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Account Type:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{tpartition['TUC']['classification']||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{tpartition['EXP']['classification']||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{tpartition['EQF']['classification']||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Account Type - Detail:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        <ng>
                            {{tpartition['TUC']['type']||"-"}}
                        </ng>
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        <ng>
                            {{tpartition['EXP']['type']||"-"}}
                        </ng>
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        <ng>
                            {{tpartition['EQF']['type']||"-"}}
                        </ng>
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Bureau Code:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['responsibility'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['responsibility'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['responsibility'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Account Status:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{tpartition['TUC']['type_definition_flags']['account_status']||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{tpartition['EXP']['type_definition_flags']['account_status']||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{tpartition['EQF']['type_definition_flags']['account_status']||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Monthly Payment:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['monthly_payment']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['monthly_payment']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['monthly_payment']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Date Opened:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['date_opened']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['date_opened']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['date_opened']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Balance:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['balance']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['balance']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['balance']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    No. of Months (terms):
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['terms'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['terms'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['terms'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    High Credit:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['high_balance']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['high_balance']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['high_balance']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Credit Limit:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['limit']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['limit']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['limit']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Past Due:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['past_due_amount']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['past_due_amount']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['past_due_amount']|currencyIgnoreEmpty)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Payment Status:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['payment_status'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['payment_status'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['payment_status'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Last Reported:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['balance_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['balance_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['balance_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Comments:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="comment in tpartition['TUC']['comments']">
                        <div>
                            {{comment['comment_text']}}
                        </div>
                    </ng-repeat>
                    <ng ng-if="tpartition['TUC']['comments'].length==0">-</ng>
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="comment in tpartition['EXP']['comments']">
                        <div>
                            {{comment['comment_text']}}
                        </div>
                    </ng-repeat>
                    <ng ng-if="tpartition['EXP']['comments'].length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="comment in tpartition['EQF']['comments']">
                        <div>
                            {{comment['comment_text']}}
                        </div>
                    </ng-repeat>
                    <ng ng-if="tpartition['EQF']['comments'].length==0">-</ng>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Date Last Active:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['status_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['status_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['status_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Date of Last Payment:
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['TUC']['last_payment_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info">
                    <ng-repeat>
                        {{(tpartition['EXP']['last_payment_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat>
                        {{(tpartition['EQF']['last_payment_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
        </table>
    </script>
    <script type='text/ng-template' id="tradeLinePartitionTmpl">
        <table cellpadding="0" cellspacing="0" class="crPrint" style="width:100%">
            <tr>
                <td>
                    <ng-include src="'tradeLinePartitionBasic'" onload="tpartition = tpartition"></ng-include>
                    <div class="hstry-header hstry-header-2yr">
                        Two-Year payment history
                        <img src="/images/tu/legend-icon.gif" onclick="showLegend(this)" />
                    </div>
                    {{ historys = (tpartition|expHistory2year);""}}
                    <table cellpadding="0" cellspacing="0" class="rpt_content_table addr_hsrty">
                        <tr>
                            <td class="label leftHeader rowAlt">
                                Month
                            </td>
                            <td ng-repeat="history in historys" class="info">
                                {{history.month}}
                            </td>
                        </tr>
                        <tr>
                            <td class="label leftHeader">
                                Year
                            </td>
                            <td ng-repeat="history in historys" class="info">
                                {{history.year}}
                            </td>
                        </tr>
                        <tr ng-show="{{is3B}}">
                            <td ng-class="expFindDerogatoryIndicator(tpartition,'TUC','rowAlt')">
                                TransUnion
                            </td>
                            <td ng-repeat="history in historys" ng-class="history.tuc.css" class="info">
                                {{history.tuc.name}}
                            </td>
                        </tr>
                        <tr >
                            <td ng-class="expFindDerogatoryIndicator(tpartition,'EXP','')">
                                Experian
                            </td>
                            <td ng-repeat="history in historys" ng-class="history.exp.css" class="info">
                                {{history.exp.name}}
                            </td>
                        </tr>
                        <tr ng-show="{{is3B}}">
                            <td ng-class="expFindDerogatoryIndicator(tpartition,'EQF','rowAlt')">
                                Equifax
                            </td>
                            <td ng-repeat="history in historys" ng-class="history.eqf.css" class="info">
                                {{history.eqf.name}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--<div class="hstry-divider"></div>-->
    </script>
    <div class="rpt_content_wrapper">
        <div class="rpt_fullReport_header" id="AccountHistory">
            <span class="return_topSpan">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                   target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon.gif">Back to Top
                </a>
            </span>Account History
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Information on accounts you have opened in the past is displayed below.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="!accounts">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <div>
            <address-history>
                <img src="images/loading.gif" ng-show="Is3B" style="position: relative; z-index: 999;
                                    width: 20px;" alt="" />
            </address-history>
        </div>
    </div>
    <div class="content_divider">
    </div>
    <!--Account history ends-->
    <!--Inquiry starts-->
    <div class="rpt_content_wrapper" id="Inquiries">
        <div class="rpt_fullReport_header">
            <span class="return_topSpan">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                   target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon.gif">Back to Top
                </a>
            </span>Inquiries
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below are the names of people and/or organizations who have obtained a copy of your
                        Credit Report. Inquiries such as these can remain on your credit file for up to
                        two years.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="inquiries.length==0">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_content_contacts" ng-if="inquiries.length>0">
            <tr>
                <th class="tbheader" width="30%">
                    Creditor Name
                </th>
                <th class="tbheader" width="30%">
                    Type of Business
                </th>
                <th class="tbheader" width="15%">
                    Date of inquiry
                </th>
                <th class="tbheader" width="15%">
                    Credit Bureau
                </th>
            </tr>
            <tr ng-class-even="'rowAlt'" ng-repeat="inquiry in inquiries|orderBy:sortExperianInquiryDate:true">
                <td class="info" width="30">
                    {{(inquiry['company_name'])||"-"}}
                </td>
                <td class="info" width="30%">
                    {{(inquiry['company_type'])||"-"}}
                </td>
                <td class="info" width="15%">
                    {{(inquiry['date_of_inquiry']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                </td>
                <td class="info" width="15%">
                    {{(inquiry['bureau'])||"-"}}
                </td>
            </tr>
        </table>
    </div>
    <!--Inquiry ends-->
    <div class="content_divider">
    </div>
    <!--Public information starts-->
    {{ PublicRecords = reports.PulblicRecordPartition;"" }}
    <div class="rpt_content_wrapper" id="PublicInformation">
        <div class="rpt_fullReport_header">
            <span class="return_topSpan">
                <a href="##reportTop" target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon.gif">Back to Top
                </a>
            </span>Public Information
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below is an overview of your public records and can include details of bankruptcy
                        filings, court records, tax liens and other monetary judgments. Public records typically
                        remain on your Credit Report for 7 - 10 years.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="public_records.length==0">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <ng ng-repeat="pulblicRecord in public_records">
            <div class="sub_header">
                {{pulblicRecord["title"]}}
            </div>
            <table class="rpt_content_table rpt_content_header rpt_table4column">
                <tr>
                    <th>
                    </th>
                    <th class="headerTUC" ng-show="{{is3B}}">
                        TransUnion
                    </th>
                    <th class="headerEXP">
                        Experian
                    </th>
                    <th class="headerEQF" ng-show="{{is3B}}">
                        Equifax
                    </th>
                </tr>
                <tr class="rowAlt">
                    <td class="label">
                        Type:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['TUC']['record_type'])||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info">
                        <ng-repeat>
                            {{(pulblicRecord['EXP']['record_type'])||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['EQF']['record_type'])||"-"}}
                        </ng-repeat>
                    </td>
                </tr> 
                <tr>
                    <td class="label">
                        Status:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['TUC']['description'])||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info">
                        <ng-repeat>
                            {{(pulblicRecord['EXP']['description'])||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['EQF']['description'])||"-"}}
                        </ng-repeat>
                    </td>
                </tr>
                <tr class="rowAlt">
                    <td class="label">
                        Date Filed/Reported:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['TUC']['filed_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info">
                        <ng-repeat >
                            {{(pulblicRecord['EXP']['filed_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['EQF']['filed_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                        </ng-repeat>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        Reference#:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['TUC']['reference_number'])||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info">
                        <ng-repeat>
                            {{(pulblicRecord['EXP']['reference_number'])||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['EQF']['reference_number'])||"-"}}
                        </ng-repeat>
                    </td>
                </tr>
                <tr class="rowAlt">
                    <td class="label">
                        Date Settled:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['TUC']['status_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info">
                        <ng-repeat>
                            {{(pulblicRecord['EXP']['status_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['EQF']['status_date']|dateIgnoreTimezone:'MM/dd/yyyy')||"-"}}
                        </ng-repeat>
                    </td>
                </tr>
                
                <tr class="rowAlt">
                    <td class="label">
                        Liability Amount:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['TUC']['liability']|trim)||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info">
                        <ng-repeat>
                            {{(pulblicRecord['EXP']['liability']|trim)||"-"}}
                        </ng-repeat>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat>
                            {{(pulblicRecord['EQF']['liability']|trim)||"-"}}
                        </ng-repeat>
                    </td>
                </tr>
                <tr class="rowAlt">
                    <td class="label">
                        Remarks:
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat ng-repeat="comment in pulblicRecord['TUC']['comments']">
                            <div>
                                {{comment['comment_text']}}
                            </div>
                        </ng-repeat>
                        <ng ng-if="pulblicRecord['TUC']['comments'].length==0">-</ng>
                    </td>
                    <td class="info">
                        <ng-repeat ng-repeat="comment in pulblicRecord['EXP']['comments']">
                            <div>
                                {{comment['comment_text']}}
                            </div>
                        </ng-repeat>
                        <ng ng-if="pulblicRecord['EXP']['comments'].length==0">-</ng>
                    </td>
                    <td class="info" ng-show="{{is3B}}">
                        <ng-repeat ng-repeat="comment in pulblicRecord['EQF']['comments']">
                            <div>
                                {{comment['comment_text']}}
                            </div>
                        </ng-repeat>
                        <ng ng-if="pulblicRecord['EQF']['comments'].length==0">-</ng>
                    </td> 
                </tr>
            </table>
        </ng>
    </div>
    <div class="content_divider">
    </div>
    <!--Public information ends-->
    <!--Creditor starts-->
    <div class="rpt_content_wrapper" id="CreditorContacts">
        <div class="rpt_fullReport_header">
            <span class="return_topSpan">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                   target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon.gif">Back to Top
                </a>
            </span>Creditor Contacts
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        The names of people and/or organizations who have obtained a copy of your credit
                        report are listed below.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="creditors.length==0">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_content_contacts" ng-if="creditors.length>0">
            <tr>
                <th class="tbheader" width="40%">
                    Creditor Name
                </th>
                <th class="tbheader" width="40%">
                    Address
                </th>
                <th class="tbheader" width="20%">
                    Phone Number
                </th>
            </tr>
            <tr ng-class-even="'rowAlt'" ng-repeat="subsr in creditors">
                <td class="info" width="40%">
                    {{(subsr['name'])||"-"}}
                </td>
                <td class="info" width="30%">
                    {{subsr['address']}}<br />
                    {{subsr['city']|trim}}<span ng-if="subsr['state']|trim">,&nbsp;</span>{{subsr['state']|trim}}&nbsp;{{subsr['zipcode']|zipcode}}
                </td>
                <td class="info" width="30%">
                    {{(subsr['phone']|telephone)||"-"}}
                </td>
            </tr>
        </table>
    </div>
    <!--Creditor ends-->
    <div class="rpt_content_wrapper">
        <div class="footer_content ">
            <div class="link_header">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')" target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon2.gif">Back to Top
                </a><a href="javascript:void(0);"
                       style="margin-right: 10%;" onclick="return PrintPage()">
                    <img src="/images/tu/print_icon.gif">Print this page
                </a><a class="imgDownloadAction" href="javascript:void(0);" onclick="generateCreditReport()">
                    <img src="/images/tu/download.jpg" />Download this report
                </a>
            </div>
        </div>
    </div>
</div>
<div ng-if="isLoaded&&!valid">
    <div class="rpt_content_wrapper" id="Div1">
        <div class="link_header">
            <div style="float: left; font-size: 11px;" ng-if="reportHistory&&reportHistory.length>1">
                Report History:
                <select name="ddlReportHistory" class="user-select" style="font-size: 11px; width: inherit !important;
                    height: 18px;" ng-model="selectedHistory" ng-options="hry.Id as hry.Date for hry in reportHistory track by hry.Id"
                        ng-change="reportHistoryChanged()"></select>
            </div>
        </div>
    </div>
    <br />
    <span style="color: Red;">
        You have an issue with viewing your Credit Report <ng ng-if="selectedHistory&&selectedHistory.Id">- {{activeReportReference}}</ng>. Please
        contact customer service
    </span><br>
    <br>
    <br>
</div>
<div id="HistoryLegendDiv" class="legend">
    <div class="header">
        Legend<a onclick="$('#HistoryLegendDiv').toggle();" title="close">X</a>
    </div>
    <div class="clear">
    </div>
    <div class="infoSection">
        <table class="legendInfo" cellpadding="0" cellspacing="4" border="0">
            <tbody>
                <tr>
                    <td class="clr hstry-ok">
                        OK
                    </td>
                    <td class="desc">
                        Current
                    </td>
                    <td class="clr hstry-120">
                        120
                    </td>
                    <td class="desc">
                        120 Days Late
                    </td>
                </tr>
                <tr>
                    <td class="clr hstry-unknown">
                        ND
                    </td>
                    <td class="desc">
                        No Data Provided*
                    </td>
                    <td class="clr hstry-150">
                        150
                    </td>
                    <td class="desc">
                        150 Days Late
                    </td>
                </tr>
                <tr>
                    <td class="clr hstry-30 ">
                        30
                    </td>
                    <td class="desc">
                        30 Days Late
                    </td>
                    <td class="clr hstry-180 ">
                        180
                    </td>
                    <td class="desc">
                        180 Days Late
                    </td>
                </tr>
                <tr>
                    <td class="clr hstry-60 ">
                        60
                    </td>
                    <td class="desc">
                        60 Days Late / Generic Derogatory
                    </td>
                    <td class="clr hstry-other">
                        CO
                    </td>
                    <td class="desc">
                        Chargeoff or Collection
                    </td>
                </tr>
                <tr>
                    <td class="clr hstry-90 ">
                        90
                    </td>
                    <td class="desc">
                        90 Days Late
                    </td>
                    <td class="clr hstry-other">
                        RF
                    </td>
                    <td class="desc">
                        Repossession or Foreclosure
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td class="desc">
                        &nbsp;
                    </td>
                    <td class="clr hstry-other">
                        PP
                    </td>
                    <td class="desc">
                        Payment Plan
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="desc">
                        **Sometimes the credit bureaus do not have information from a particular month on
                        file.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="clear">
    </div>
</div>
