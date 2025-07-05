<div ng-show="!isLoaded">
    Loading.. please wait
</div>
<div ng-if="isLoaded&&valid">
    <div class="rpt_content_wrapper" id="reportTop">
        <div class="link_header">
            <div style="float:left;font-size:11px;" ng-if="reportHistory&&reportHistory.length>1">
                Report History:
                <select name="ddlReportHistory" class="user-select" style="font-size: 11px; width: inherit !important;
                    height: 18px;" ng-model="selectedHistory" ng-options="hry.Id as hry.Date for hry in reportHistory track by hry.Id" ng-change="reportHistoryChanged()">
                </select>
            </div>
            <a href="javascript:void(0);" style="text-decoration: none; color: #333; display: none;" class="aPrintLoader">Loading.. </a>
            <a class="imgPrintAction" href="javascript:void(0);" onclick="return PrintPage()">
                <img src="/images/tu/print_icon.gif">Print this page </a>
            <div style="display:inline-block;width:190px;">
                <a href="javascript:void(0);" style="text-decoration: none; color: #333; display: none;" class="aDownloadLoader">
                        Loading.. </a>
                <a class="imgDownloadAction" href="javascript:void(0);" onclick="downloadCreditReport()">
                    <img src="/images/tu/download.jpg" />Download this report</a>
            </div>
        </div>
        <div class="reportTopHeader" ng-show="is3B">
            Three Bureau Credit Report
        </div>
        <div class="reportTopHeader" ng-show="!is3B">
            One Bureau Credit Report
        </div>
        {{ reportDates = (makeArray(reports.Sources.Source)|orderBy:sortSourceInquiryDate:true);""}}
        <table id="reportTop" class="reportTop_content">
            <tr>
                <td class="label" style="width: 15%; text-align: right">
                    Reference #
                </td>
                <td style="width: 35%;">
                    {{referenceNo}}
                </td>
                <td style="width: 30%; text-align: right" class="label">
                    Report Date:
                </td>
                <td style="width: 15%;">
                    <ng ng-if="reportDates.length>0">
                        {{reportDates[0].InquiryDate['$']|date:'MM/dd/yyyy'}}
                    </ng>
                </td>
            </tr>
        </table>
        <div class="link_header" style="padding-bottom: 0px;">
            <span style="font-size: 85%; font-weight: bold">Quick Links:</span>&nbsp;<a href="javascript:void(0);" id="TopCreditScore" ng-click="scrollTo('CreditScore')" target="_self">Credit&nbsp;Score</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopSummary"
                ng-click="scrollTo('Summary')" target="_self">Summary</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopAccountHistory" ng-click="scrollTo('AccountHistory')" target="_self">Account History</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopInquiries"
                ng-click="scrollTo('Inquiries')" target="_self">Inquiries</a>&nbsp;/&nbsp;<a href="javascript:void(0);" id="TopCreditorContacts" ng-click="scrollTo('CreditorContacts')" target="_self">Creditor Contacts
            </a>
            <!--/ <a href="javascript:void(0);" ng-click="scrollTo('PublicInformation')"
                            target="_self">Public Information</a>-->
        </div>
    </div>
    <!--source: crBorrower.xls-->
    <!--PersonInfo start-->
    <!--source: crBorrower.xls-->
    <!--source: crBorrower.xls-->
    {{ message = reports.Message;""}} {{ Frozen = reports.SB168Frozen;"" }}
    <div ng-if="Frozen['@transunion']=='true'||Frozen['@experian']=='true'||Frozen['@equifax']=='true'">
        <table class="help_text" style="border: solid 1px #dfdfdf; margin-top: 10px;">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/warning-icon.png">
                    </td>
                    <td>
                        <font color="red" size="2"><b>***SECURITY FREEZE: </b></font>THE FOLLOWING CREDIT BUREAUS REPORT THAT YOU HAVE PLACED A SECURITY FREEZE OR LOCK ON THIS FILE. HOWEVER, THE FILE HAS BEEN DELIVERED TO YOU UNDER THE APPLICABLE EXEMPTION PROVISIONS &#40;PROVIDING
                        A CONSUMER WITH A COPY OF HIS OR HER CREDIT REPORT UPON THE CONSUMER'S REQUEST&#41;:<br />
                        <b><span ng-if="Frozen['@transunion']=='true'" class="tranUnionClr">TRANSUNION</span>
                            <ng-if ng-if="Frozen['@experian']=='true'||Frozen['@equifax']=='true'">, </ng-if>
                            <span ng-if="Frozen['@experian']=='true'" class="experianClr">EXPERIAN</span>
                            <ng-if ng-if="Frozen['@equifax']=='true'">, </ng-if>
                            <span ng-if="Frozen['@equifax']=='true'" class="equifaxClr">EQUIFAX</span> </b>
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
    {{ borrower = reports.Borrower;""}} {{ crdStmt = makeArray(borrower.CreditStatement);"" }}
    <div ng-show="crdStmt.length>0">
        <div class="rpt_content_wrapper">
            <div class="rpt_fullReport_header" style="display: block;">
                Customer Statement
            </div>
            <table class="rpt_content_table rpt_content_header rpt_content_contacts extra_info">
                <tr>
                    <td style="width: 25%;" class="tuc_header">
                        TransUnion:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <ng-repeat ng-repeat="stmt in stmsts=(crdStmt|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                            {{stmt["@statement"]|trim}}
                        </ng-repeat>
                        <ng ng-show="stmsts.length==0">-</ng>
                    </td>
                </tr>
                <tr class="rowAlt" ng-show="{{is3B}}">
                    <td style="width: 25%;" class="exp_header">
                        Experian:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <ng-repeat ng-repeat="stmt in stmsts=(crdStmt|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                            {{stmt["@statement"]|trim}}
                        </ng-repeat>
                        <ng ng-show="stmsts.length==0">-</ng>
                    </td>
                </tr>
                <tr ng-show="{{is3B}}">
                    <td style="width: 25%;" class="eqf_header">
                        Equifax:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <ng-repeat ng-repeat="stmt in stmsts=(crdStmt|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                            {{stmt["@statement"]|trim}}
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
        <ng-if ng-if="person.Name['@first']|trim">
            {{person.Name["@first"]|trim}}&#xA0;
        </ng-if>
        <ng-if ng-if="person.Name['@middle']|trim">
            {{person.Name["@middle"]|trim}}&#xA0;
        </ng-if>
        <ng-if ng-if="person.Name['@last']">
            {{person.Name["@last"]}}
        </ng-if>
    </script>
    <script type="text/ng-template" id="tucAddressTemplate">
        {{addressLine = combineTUCAddressLine(addr);""}}
        <ng-if ng-if="addressLine">
            {{addressLine}}<br />
        </ng-if>
        <ng-if ng-if="(addr.CreditAddress['@city']|trim) || (addr.CreditAddress['@stateCode']|trim)">
            {{addr.CreditAddress['@city']|trim}},&#xA0;{{addr.CreditAddress['@stateCode']|trim}}<br />
        </ng-if>
        <ng-if ng-if="addr.CreditAddress['@postalCode']">
            {{addr.CreditAddress['@postalCode']|zipcode}}
        </ng-if>
    </script>
    <script type="text/ng-template" id="addressTemplate">
        <ng-if ng-if="addr.CreditAddress['@unparsedStreet']|trim">
            {{addr.CreditAddress['@unparsedStreet']|trim}}<br />
        </ng-if>
        <ng-if ng-if="(addr.CreditAddress['@city']|trim) || (addr.CreditAddress['@stateCode']|trim)">
            {{addr.CreditAddress['@city']|trim}},&#xA0;{{addr.CreditAddress['@stateCode']|trim}}<br />
        </ng-if>
        <ng-if ng-if="addr.CreditAddress['@postalCode']">
            {{addr.CreditAddress['@postalCode']|zipcode}}
        </ng-if>
    </script>
    <script type="text/ng-template" id="scoreRiskFactorText">
        <ng ng-if="factor['@FactorType'] !='Positive'">
            {{ showDetail = (factor.Factor['@description']);""}}
            <ng-if ng-show="showDetail">
                <b>{{factor.Factor['@description']}}.</b>
                <a style="text-decoration: none" href="#" ng-click="show=(!showDetail||!show)">
                    <ng ng-show="show">[-]</ng>
                    <ng ng-show="!show">[+]</ng>
                </a>
                <div ng-show="show">
                    <span ng-repeat="fText in makeArray(factor.FactorText)">{{fText['$']}} </span>
                </div>
            </ng-if>
            <ng-if ng-show="!showDetail">
                <span ng-repeat="fText in makeArray(factor.FactorText)">{{fText['$']}} </span>
            </ng-if>
        </ng>
    </script>
    <div class="rpt_content_wrapper">
        <div class="rpt_fullReport_header" style="display: block;">
            Personal Information
        </div>
        {{ BorrowerName = makeArray(borrower.BorrowerName);"" }} {{Birth = makeArray(borrower.Birth);""}} {{ borrowerAddress = makeArray(borrower.BorrowerAddress);"" }} {{PreviousAddress = makeArray(borrower.PreviousAddress);""}} {{ Employer = makeArray(borrower.Employer);""}}
        {{ Source = makeArray(reports.Sources.Source);""}}
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below is your personal information as it appears in your credit file. This information includes your legal name, current and previous addresses, employment information and other details.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC">
                    TransUnion
                </th>
                <th class="headerEXP" ng-show="{{is3B}}">
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
                <td class="info">
                    <ng-repeat ng-repeat="source in sources=(Source|filter:{Bureau:{'@symbol':'TUC'}})">
                        {{source.InquiryDate["$"]|date:'MM/dd/yyyy'}}
                    </ng-repeat>
                    <ng ng-show="sources.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="source in sources=(Source|filter:{Bureau:{'@symbol':'EXP'}})">
                        {{source.InquiryDate["$"]|date:'MM/dd/yyyy'}}
                    </ng-repeat>
                    <ng ng-show="sources.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="source in sources=(Source|filter:{Bureau:{'@symbol':'EQF'}})">
                        {{source.InquiryDate["$"]|date:'MM/dd/yyyy'}}
                    </ng-repeat>
                    <ng ng-show="sources.length==0">-</ng>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Name:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="name in names=(BorrowerName|filter:{NameType:{'@description':'Primary'},Source:{Bureau:{'@symbol':'TUC'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="names.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in names=(BorrowerName|filter:{NameType:{'@description':'Primary'},Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="names.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in names=(BorrowerName|filter:{NameType:{'@description':'Primary'},Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="names.length==0">-</ng>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Also Known As:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="name in alsoNames=(BorrowerName|filter:{NameType:{'@description':'Also Known As'},Source:{Bureau:{'@symbol':'TUC'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="alsoNames.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in alsoNames=(BorrowerName|filter:{NameType:{'@description':'Also Known As'},Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="alsoNames.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in alsoNames=(BorrowerName|filter:{NameType:{'@description':'Also Known As'},Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="alsoNames.length==0">-</ng>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Former:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="name in alsoNames=(BorrowerName|filter:{NameType:{'@description':'Former'},Source:{Bureau:{'@symbol':'TUC'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="alsoNames.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in alsoNames=(BorrowerName|filter:{NameType:{'@description':'Former'},Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="alsoNames.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="name in alsoNames=(BorrowerName|filter:{NameType:{'@description':'Former'},Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div>
                            <ng-include src="'personNameTemplate'" onload="person = name"></ng-include>
                        </div>
                    </ng-repeat>
                    <ng ng-show="alsoNames.length==0">-</ng>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Date of Birth:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="birth in dob = (Birth|filter:{Source:{Bureau:{'@symbol':'TUC'}},'@date':'!1900-01-01'})">
                        <div>
                            {{getBirthDate(birth)||"-"}}
                        </div>
                    </ng-repeat>
                    <ng ng-show="dob.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="birth in dob = (Birth|filter:{Source:{Bureau:{'@symbol':'EXP'}},'@date':'!1900-01-01'})">
                        <div>
                            {{getBirthDate(birth)||"-"}}
                        </div>
                    </ng-repeat>
                    <ng ng-show="dob.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="birth in dob= (Birth|filter:{Source:{Bureau:{'@symbol':'EQF'}},'@date':'!1900-01-01'})">
                        <div>
                            {{getBirthDate(birth)||"-"}}
                        </div>
                        <ng-if ng-if="e_dob.length=0">-</ng-if>
                    </ng-repeat>
                    <ng ng-show="dob.length==0">-</ng>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Current Address(es):
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="addr in addrs=(borrowerAddress|filter:{Source:{Bureau:{'@symbol':'TU'}}})">
                        <div>
                            <ng-include src="'tucAddressTemplate'" onload="addr = addr"></ng-include>
                            <div ng-if="addr['@dateUpdated'].indexOf('1900-01')==-1">
                                {{addr['@dateUpdated']|date:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="addrs.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="addr in addrs=(borrowerAddress|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = addr"></ng-include>
                            <div ng-if="addr['@dateUpdated'].indexOf('1900-01')==-1">
                                {{addr['@dateUpdated']|date:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="addrs.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="addr in addrs=(borrowerAddress|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = addr"></ng-include>
                            <div ng-if="addr['@dateUpdated'].indexOf('1900-01')==-1">
                                {{addr['@dateUpdated']|date:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="addrs.length==0">-</ng>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Previous Address(es):
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="addr in addrs=(PreviousAddress|filter:{Source:{Bureau:{'@symbol':'TU'}}})">
                        <div>
                            <ng-include src="'tucAddressTemplate'" onload="addr = addr"></ng-include>
                            <div ng-if="addr['@dateUpdated'].indexOf('1900-01')==-1">
                                {{addr['@dateUpdated']|date:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="addrs.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="addr in addrs=(PreviousAddress|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = addr"></ng-include>
                            <div ng-if="addr['@dateUpdated'].indexOf('1900-01')==-1">
                                {{addr['@dateUpdated']|date:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="addrs.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="addr in addrs=(PreviousAddress|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div>
                            <ng-include src="'addressTemplate'" onload="addr = addr"></ng-include>
                            <div ng-if="addr['@dateUpdated'].indexOf('1900-01')==-1">
                                {{addr['@dateUpdated']|date:'MM/yyyy'}}
                            </div>
                        </div>
                    </ng-repeat>
                    <ng ng-show="addrs.length==0">-</ng>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Employers:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="emp in emps=(Employer|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        <div>
                            <ng-if ng-if="emp['@name']|trim">
                                {{emp["@name"]|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="emp.CreditAddress['@unparsedStreet']|trim">
                                {{emp.CreditAddress['@unparsedStreet']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="(emp.CreditAddress['@city']|trim) || (emp.CreditAddress['@stateCode']|trim)">
                                {{emp.CreditAddress['@city']|trim}},&#xA0;{{emp.CreditAddress['@stateCode']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="addr.CreditAddress['@postalCode']">
                                {{emp.CreditAddress['@postalCode']|zipcode}}
                            </ng-if>
                        </div>
                    </ng-repeat>
                    <ng ng-show="emps.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="emp in emps=(Employer|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div>
                            <ng-if ng-if="emp['@name']|trim">
                                {{emp["@name"]|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="emp.CreditAddress['@unparsedStreet']|trim">
                                {{emp.CreditAddress['@unparsedStreet']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="(emp.CreditAddress['@city']|trim) || (emp.CreditAddress['@stateCode']|trim)">
                                {{emp.CreditAddress['@city']|trim}},&#xA0;{{emp.CreditAddress['@stateCode']|trim}},<br />
                            </ng-if>
                            <ng-if ng-if="addr.CreditAddress['@postalCode']">
                                {{emp.CreditAddress['@postalCode']|zipcode}}
                            </ng-if>
                        </div>
                    </ng-repeat>
                    <ng ng-show="emps.length==0">-</ng>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="emp in emps=(Employer|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div>
                            <ng-if ng-if="emp['@name']|trim">
                                {{emp["@name"]|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="emp.CreditAddress['@unparsedStreet']|trim">
                                {{emp.CreditAddress['@unparsedStreet']|trim}}<br />
                            </ng-if>
                            <ng-if ng-if="(emp.CreditAddress['@city']|trim) || (emp.CreditAddress['@stateCode']|trim)">
                                {{emp.CreditAddress['@city']|trim}},&#xA0;{{emp.CreditAddress['@stateCode']|trim}},<br />
                            </ng-if>
                            <ng-if ng-if="addr.CreditAddress['@postalCode']">
                                {{emp.CreditAddress['@postalCode']|zipcode}}
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
            <span class="return_topSpan"><a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                target="_self" class="moreAboutLink">
                <img src="/images/tu/back_icon.gif">Back to Top </a></span>Credit Score
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Your Credit Score is a representation of your overall credit health. Most lenders utilize some form of credit scoring to help determine your credit worthiness.
                    </td>
                </tr>
            </tbody>
        </table>
        {{ TUCVantageScore = TUCVantageScore;""}} {{ EXPVantageScore = EXPVantageScore;""}} {{ EQFVantageScore = EQFVantageScore;""}} {{ tucVScore= TUCVantageScore['@riskScore']|number;""}} {{ expVScore= EXPVantageScore['@riskScore']|number;""}} {{ eqfVScore=
        EQFVantageScore['@riskScore']|number;""}}
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC">
                    TransUnion
                </th>
                <th class="headerEXP" ng-show="{{is3B}}">
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
                <td class="info">
                    {{ tucVScore
                    <300?((tucVScore==1 || tucVScore==4) ? "Not Reported - Code: "+tucVScore: "Score Not Reported"):(tucVScore|| "-")}} </td>
                        <td class="info" ng-show="{{is3B}}">
                            {{ expVScore
                            <300?((expVScore==1 || expVScore==4) ? "Not Reported - Code: "+expVScore: "Score Not Reported"):(expVScore|| "-")}} </td>
                                <td class="info" ng-show="{{is3B}}">
                                    {{ eqfVScore
                                    <300?((eqfVScore==1 || eqfVScore==4) ? "Not Reported - Code: "+eqfVScore: "Score Not Reported"):(eqfVScore|| "-")}} </td>
            </tr>
            <tr>
                <td class="label">
                    Lender Rank:
                </td>
                <td class="info">
                    {{(tucVScore|number)
                    <300? "-":(vantageScoreFactorGrade(tucVScore)|| "-")}} </td>
                        <td class="info" ng-show="{{is3B}}">
                            {{(expVScore|number)
                            <300? "-":(vantageScoreFactorGrade(expVScore)|| "-")}} </td>
                                <td class="info" ng-show="{{is3B}}">
                                    {{(eqfVScore|number)
                                    <300? "-":(vantageScoreFactorGrade(eqfVScore)|| "-")}} </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Score Scale:
                </td>
                <td class="info">
                    300-850
                </td>
                <td class="info" ng-show="{{is3B}}">
                    300-850
                </td>
                <td class="info" ng-show="{{is3B}}">
                    300-850
                </td>
            </tr>
        </table>
        <div ng-show="(TUCVantageScore.CreditScoreFactor && TUCVantageScore.CreditScoreFactor.length>0)|| (EXPVantageScore.CreditScoreFactor && EXPVantageScore.CreditScoreFactor.length>0)|| (EQFVantageScore.CreditScoreFactor && EQFVantageScore.CreditScoreFactor.length>0)">
            <div class="sub_header">
                Risk Factors
                <!--<a href="#" ng-click="showAllDescription(show);" style="float: right; color: #fff;">
                    <ng ng-show="show">hide all</ng>
                    <ng ng-show="!show">show all</ng>
                </a>-->
            </div>
            <table class="rpt_content_table rpt_content_header rpt_content_contacts extra_info riskfactors">
                <tr>
                    <td style="width: 25%;" class="tuc_header">
                        TransUnion:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <div ng-if="(tucVScore|number)>=300">
                            <div class="descriptionTxt" ng-repeat="factor in factors=(makeArray(TUCVantageScore.CreditScoreFactor))">
                                <ng ng-if="factor['@bureauCode']&&(factor['@FactorType'] !='Positive')">
                                    <b ng-if="factor.Factor['@description']">{{factor.Factor['@description']}}.</b>
                                    <span ng-repeat="txt in txtFs=(makeArray(factor.FactorText)|filter:isTUCFactorTextFactor)">
                                        <b>{{txt['$'].replace('factor: ','')}}</b>
                                    </span> {{ showDetail = (factor.Factor['@description'] || txtFs.length>0);""}}
                                    <ng-if ng-show="showDetail">
                                        <a style=" text-decoration:none" ng-show="showDetail" href="#" ng-click="show=!show">
                                            <ng ng-show="show">[-]</ng>
                                            <ng ng-show="!show">[+]</ng>
                                        </a>
                                        <div ng-show="show">
                                            <span ng-repeat="fText in makeArray(factor.FactorText)|filter:isTUCFactorTextExplain">
                                                {{fText['$'].replace('explain: ','')}}
                                            </span>
                                            <span ng-repeat="txt in makeArray(factor.FactorText)|filter:isTUCFactorText">
                                                {{txt['$']}}
                                            </span>
                                        </div>
                                    </ng-if>
                                    <ng-if ng-show="!showDetail">
                                        <span ng-repeat="fText in makeArray(factor.FactorText)|filter:isTUCFactorTextExplain">
                                            {{fText['$'].replace('explain: ','')}}
                                        </span>
                                        <span ng-repeat="txt in makeArray(factor.FactorText)|filter:isTUCFactorText">
                                            {{txt['$']}}
                                        </span>
                                    </ng-if>
                                </ng>
                            </div>
                            <ng ng-if="factors.length==0">-</ng>
                        </div>
                        <div ng-if="(tucVScore|number)<300">
                            <div class="descriptionTxt" ng-if="(expVScore|number)!=1">
                                <b>There was not enough credit history available to generate a score.</b>
                            </div>
                            <div class="descriptionTxt" ng-if="(expVScore|number)==1">
                                <b>Unable to generate score. Please contact the credit bureau for assistance.</b>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="rowAlt" ng-show="{{is3B}}">
                    <td style="width: 25%;" class="exp_header">
                        Experian:
                    </td>
                    <td style="width: 75%;" colspan="3" class="info">
                        <div ng-if="(expVScore|number)>=300">
                            <div class="descriptionTxt" ng-repeat="factor in factors=(makeArray(EXPVantageScore.CreditScoreFactor))">
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
                            <div class="descriptionTxt" ng-repeat="factor in factors=(makeArray(EQFVantageScore.CreditScoreFactor))">
                                <ng-include src="'scoreRiskFactorText'" onload="factor = factor"></ng-include>
                            </div>
                            <ng ng-if="factors.length==0">-</ng>
                        </div>
                        <div ng-if="(eqfVScore|number)<300">
                            <div class="descriptionTxt" ng-if="(expVScore|number)!=1">
                                <b>There was not enough credit history available to generate a score.</b>
                            </div>
                            <div class="descriptionTxt" ng-if="(expVScore|number)==1">
                                <b>Unable to generate score. Please contact the credit bureau for assistance.</b>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="info" style="line-height: 18px;">
                        <div class="descriptionTxt">
                            <p>
                                The score(s) on your IdentityIQ credit report (using the VantageScore® 3.0 model) are provided as a tool to help you understand how lenders may view the data contained in your credit reports and evaluate your credit risk. We provide these scores solely
                                for educational purposes. IdentityIQ does not offer credit; delivery of these scores does not qualify you for any loan. The scoring model your lender uses may be different than the VantageScore® 3.0. As a result, the score
                                and score factors we have delivered may show differences when compared to the score and score factors produced by your lender's scoring model. Please also understand that lenders use multiple sources of information when
                                underwriting a loan and making lending decisions. Credit scores are just one factor that may be used and each lender will have different criteria they consider.
                            </p>
                            <p>
                                IdentityIQ provides informational materials along with your credit report(s) and score(s) these materials are educational in nature and intended to broaden your understanding of how credit scoring works. They should not be construed as advice in handling
                                your financial problems or making financial decisions. If you are having trouble keeping up with your bill payments or experiencing other financial difficulties, please contact a non-profit credit counseling service for
                                assistance. These materials are for educational purposes only.
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
            <span class="return_topSpan"><a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                target="_self" class="moreAboutLink">
                <img src="/images/tu/back_icon.gif">Back to Top </a></span>Summary
        </div>
        {{ tradingSummary = reports.Summary.TradelineSummary;"" }} {{ publicRecordSummary = reports.Summary.PublicRecordSummary;"" }} {{ inquirySummary = reports.Summary.InquirySummary;"" }} {{ tradeLinePartition = reports.TradeLinePartition;"" }}
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below is an overview of your present and past credit status including open and closed accounts and balance information.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC">
                    TransUnion
                </th>
                <th class="headerEXP" ng-show="{{is3B}}">
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
                <td class="info">
                    {{(tradingSummary.TransUnion['@TotalAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Experian['@TotalAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Equifax['@TotalAccounts'])||"-"}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Open Accounts:
                </td>
                <td class="info">
                    {{(tradingSummary.TransUnion['@OpenAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Experian['@OpenAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Equifax['@OpenAccounts'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Closed Accounts:
                </td>
                <td class="info">
                    {{(tradingSummary.TransUnion['@CloseAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Experian['@CloseAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Equifax['@CloseAccounts'])||"-"}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Delinquent:
                </td>
                <td class="info">
                    {{(tradingSummary.TransUnion['@DelinquentAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Experian['@DelinquentAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Equifax['@DelinquentAccounts'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Derogatory:
                </td>
                <td class="info">
                    {{(tradingSummary.TransUnion['@DerogatoryAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Experian['@DerogatoryAccounts'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Equifax['@DerogatoryAccounts'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Collection:
                </td>
                <td class="info">
                    {{findDerogatoryCount(tradeLinePartition,"TUC")}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{findDerogatoryCount(tradeLinePartition,"EXP")}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{findDerogatoryCount(tradeLinePartition,"EQF")}}
                </td>
            </tr>
            <tr>
                <td class="label">
                    Balances:
                </td>
                <td class="info">
                    {{(tradingSummary.TransUnion['@TotalBalances']|currency)||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Experian['@TotalBalances']|currency)||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(tradingSummary.Equifax['@TotalBalances']|currency)||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Payments:
                </td>
                <td class="info">
                    <span class="Rsmall">{{(tradingSummary.TransUnion['@TotalMonthlyPayments']|currency)||"-"}}
                    </span>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <span class="Rsmall">{{(tradingSummary.Experian['@TotalMonthlyPayments']|currency)||"-"}}
                    </span>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <span class="Rsmall">{{(tradingSummary.Equifax['@TotalMonthlyPayments']|currency)||"-"}}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Public Records:
                </td>
                <td class="info">
                    {{(publicRecordSummary.TransUnion['@NumberOfRecords'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(publicRecordSummary.Experian['@NumberOfRecords'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(publicRecordSummary.Equifax['@NumberOfRecords'])||"-"}}
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Inquiries(2 years):
                </td>
                <td class="info">
                    {{(inquirySummary.TransUnion['@NumberInLast2Years'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(inquirySummary.Experian['@NumberInLast2Years'])||"-"}}
                </td>
                <td class="info" ng-show="{{is3B}}">
                    {{(inquirySummary.Equifax['@NumberInLast2Years'])||"-"}}
                </td>
            </tr>
        </table>
    </div>
    <div class="content_divider">
    </div>
    <!--Summary ends-->
    <!--Account history starts-->
    <script type="text/ng-template" id="tradeLinePartitionBasic">
        {{tradlines = makeArray(tpartition.Tradeline);""}}
        <div class="sub_header">
            {{tradlines[0]['@creditorName']}}
            <ng ng-if="tpartition['@accountTypeSymbol']=='Y'">
                &nbsp;(Original Creditor: {{tradlines[0].CollectionTrade['@originalCreditor']}})
            </ng>
        </div>
        <table class="rpt_content_table rpt_content_header rpt_table4column">
            <tr>
                <th>
                </th>
                <th class="headerTUC">
                    TransUnion
                </th>
                <th class="headerEXP" ng-show="{{is3B}}">
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
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline['@accountNumber'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline['@accountNumber'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline['@accountNumber'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Account Type:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tpartition['@accountTypeAbbreviation'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tpartition['@accountTypeAbbreviation'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tpartition['@accountTypeAbbreviation'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Account Type - Detail:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        <ng ng-if="tpartition['@accountTypeSymbol']=='Y'">
                            Collection
                        </ng>
                        <ng ng-if="tpartition['@accountTypeSymbol']!='Y'">
                            {{(tradeline.GrantedTrade.AccountType['@description'])||"-"}}
                        </ng>
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        <ng ng-if="tpartition['@accountTypeSymbol']=='Y'">
                            Collection
                        </ng>
                        <ng ng-if="tpartition['@accountTypeSymbol']!='Y'">
                            {{(tradeline.GrantedTrade.AccountType['@description'])||"-"}}
                        </ng>
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        <ng ng-if="tpartition['@accountTypeSymbol']=='Y'">
                            Collection
                        </ng>
                        <ng ng-if="tpartition['@accountTypeSymbol']!='Y'">
                            {{(tradeline.GrantedTrade.AccountType['@description'])||"-"}}
                        </ng>
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Bureau Code:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.AccountDesignator['@description'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.AccountDesignator['@description'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.AccountDesignator['@description'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Account Status:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.AccountCondition['@description'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.AccountCondition['@description'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.AccountCondition['@description'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Monthly Payment:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.GrantedTrade['@monthlyPayment']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.GrantedTrade['@monthlyPayment']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.GrantedTrade['@monthlyPayment']|currency)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Date Opened:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline['@dateOpened']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline['@dateOpened']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline['@dateOpened']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Balance:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline['@currentBalance']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline['@currentBalance']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline['@currentBalance']|currency)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    No. of Months (terms):
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.GrantedTrade['@termMonths'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.GrantedTrade['@termMonths'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.GrantedTrade['@termMonths'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    High Credit:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline['@highBalance']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline['@highBalance']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline['@highBalance']|currency)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Credit Limit:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.GrantedTrade.CreditLimit['$']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.GrantedTrade.CreditLimit['$']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.GrantedTrade.CreditLimit['$']|currency)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Past Due:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.GrantedTrade['@amountPastDue']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.GrantedTrade['@amountPastDue']|currency)||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.GrantedTrade['@amountPastDue']|currency)||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Payment Status:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.PayStatus['@description'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.PayStatus['@description'])||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.PayStatus['@description'])||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Last Reported:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline['@dateReported']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline['@dateReported']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline['@dateReported']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Comments:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        <div ng-repeat="remark in remarks=makeArray(tradeline.Remark)">
                            {{remark.RemarkCode['@description']}} &nbsp;{{remark['@customRemark']}}
                        </div>
                        <ng ng-if="remarks.length==0">-</ng>
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        <div ng-repeat="remark in remarks=makeArray(tradeline.Remark)">
                            {{remark.RemarkCode['@description']}} &nbsp;{{remark['@customRemark']}}
                        </div>
                        <ng ng-if="remarks.length==0">-</ng>
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        <div ng-repeat="remark in remarks=makeArray(tradeline.Remark)">
                            {{remark.RemarkCode['@description']}} &nbsp;{{remark['@customRemark']}}
                        </div>
                        <ng ng-if="remarks.length==0">-</ng>
                    </ng-repeat>
                </td>
            </tr>
            <tr class="rowAlt">
                <td class="label">
                    Date Last Active:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline['@dateAccountStatus']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline['@dateAccountStatus']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline['@dateAccountStatus']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
            </tr>
            <tr>
                <td class="label">
                    Date of Last Payment:
                </td>
                <td class="info">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                        {{(tradeline.GrantedTrade['@dateLastPayment']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                        {{(tradeline.GrantedTrade['@dateLastPayment']|date:'MM/dd/yyyy')||"-"}}
                    </ng-repeat>
                </td>
                <td class="info" ng-show="{{is3B}}">
                    <ng-repeat ng-repeat="tradeline in tdls=(tradlines|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                        {{(tradeline.GrantedTrade['@dateLastPayment']|date:'MM/dd/yyyy')||"-"}}
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
                    {{ historys = (tpartition|history2year);""}}
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
                        <tr>
                            <td ng-class="findDerogatoryIndicator(tpartition,'TUC','rowAlt')">
                                TransUnion
                            </td>
                            <td ng-repeat="history in historys" ng-class="history.tuc.css" class="info">
                                {{history.tuc.name}}
                            </td>
                        </tr>
                        <tr ng-show="{{is3B}}">
                            <td ng-class="findDerogatoryIndicator(tpartition,'EXP','')">
                                Experian
                            </td>
                            <td ng-repeat="history in historys" ng-class="history.exp.css" class="info">
                                {{history.exp.name}}
                            </td>
                        </tr>
                        <tr ng-show="{{is3B}}">
                            <td ng-class="findDerogatoryIndicator(tpartition,'EQF','rowAlt')">
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
            <span class="return_topSpan"><a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                target="_self" class="moreAboutLink">
                <img src="/images/tu/back_icon.gif">Back to Top </a></span>Account History
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
        <table class="rpt_content_table rpt_content_header" ng-if="!tradeLinePartition">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <div>
            <address-history> <img src="images/loading.gif" ng-show="Is3B" style="position: relative; z-index: 999;
                                    width: 20px;" alt="" /></address-history>
        </div>
    </div>
    <div class="content_divider">
    </div>
    <!--Account history ends-->
    <!--Inquiry starts-->
    {{ inquiryPartition = makeArray(reports.InquiryPartition);"" }}
    <div class="rpt_content_wrapper" id="Inquiries">
        <div class="rpt_fullReport_header">
            <span class="return_topSpan"><a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                target="_self" class="moreAboutLink">
                <img src="/images/tu/back_icon.gif">Back to Top </a></span>Inquiries
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below are the names of people and/or organizations who have obtained a copy of your Credit Report. Inquiries such as these can remain on your credit file for up to two years.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="inquiryPartition.length==0">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_content_contacts" ng-if="inquiryPartition.length>0">
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
            <tr ng-class-even="'rowAlt'" ng-repeat="inqPartition in makeArray(inquiryPartition)|orderBy:sortInquiryDate:true">
                <td class="info" width="30">
                    {{(inqPartition.Inquiry['@subscriberName'])||"-"}}
                </td>
                <td class="info" width="30%">
                    {{(inqPartition.Inquiry.IndustryCode['@description'])||"-"}}
                </td>
                <td class="info" width="15%">
                    {{(inqPartition.Inquiry['@inquiryDate']|date:'MM/dd/yyyy')||"-"}}
                </td>
                <td class="info" width="15%">
                    {{(inqPartition.Inquiry.Source.Bureau['@description'])||"-"}}
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
            <span class="return_topSpan"><a href="##reportTop" target="_self" class="moreAboutLink">
                <img src="/images/tu/back_icon.gif">Back to Top </a></span>Public Information
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        Below is an overview of your public records and can include details of bankruptcy filings, court records, tax liens and other monetary judgments. Public records typically remain on your Credit Report for 7 - 10 years.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="!(PublicRecords)">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <ng ng-repeat="pulblicRecordPartition in makeArray(PublicRecords)">
            {{ bankruptcys = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{Bankruptcy:{} });"" }}
            <div ng-show="bankruptcys.length>0">
                <div class="sub_header">
                    Bankruptcy
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Closing Date:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Bankruptcy['@dateResolved']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Bankruptcy['@dateResolved']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Bankruptcy['@dateResolved']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Asset Amount:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Bankruptcy['@assetAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Bankruptcy['@assetAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Bankruptcy['@assetAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Court:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Liability:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Bankruptcy['@liabilityAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Bankruptcy['@liabilityAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Bankruptcy['@liabilityAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Exempt Amount:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Bankruptcy['@exemptAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Bankruptcy['@exemptAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Bankruptcy['@exemptAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (bankruptcys|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ legalItems = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{LegalItem:{} });"" }}
            <div ng-show="legalItems.length>0">
                <div class="sub_header">
                    Legal Item
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Closing Satisfied:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(legalItem['@dateSatisfied']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(legalItem['@dateSatisfied']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(legalItem['@dateSatisfied']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Action Amount:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.LegalItem['@actionAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.LegalItem['@actionAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.LegalItem['@actionAmount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Court:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Plaintiff:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.LegalItem['@plaintiff'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.LegalItem['@plaintiff'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.LegalItem['@plaintiff'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ taxLiens = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{TaxLien:{} });"" }}
            <div ng-show="taxLiens.length>0">
                <div class="sub_header">
                    Tax Lien
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Released Date:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.TaxLien['@dateReleased']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.TaxLien['@dateReleased']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.TaxLien['@dateReleased']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Court:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Amount:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.TaxLien['@amount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.TaxLien['@amount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (taxLiens|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.TaxLien['@amount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (legalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ garnishments = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{Garnishment:{} });"" }}
            <div ng-show="garnishments.length>0">
                <div class="sub_header">
                    Garnishment
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <b>Status:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            <b>Date Filed/Reported:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <b>Reference#:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            <b>Date Satisfied:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Garnishment['@dateSatisfied']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Garnishment['@dateSatisfied']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Garnishment['@dateSatisfied']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <b>Court:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            <b>Garnishee:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Garnishment['@garnishee'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Garnishment['@garnishee'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Garnishment['@garnishee'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <b>Plaintiff:</b>
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Garnishment['@plaintiff'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Garnishment['@plaintiff'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Garnishment['@plaintiff'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (garnishments|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ maritalItems = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{MaritalItem:{} });"" }}
            <div ng-show="maritalItems.length>0">
                <div class="sub_header">
                    Marital Item
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Verified:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.MaritalItem['@dateVerified']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.MaritalItem['@dateVerified']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.MaritalItem['@dateVerified']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Name of Spouse:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.MaritalItem['@spouse'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.MaritalItem['@spouse'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.MaritalItem['@spouse'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (maritalItems|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ miscs = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{MiscPublicRecord:{} });"" }}
            <div ng-show="miscs.length>0">
                <div class="sub_header">
                    Miscellaneous
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Information:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.MiscPublicRecord['@miscInformation'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.MiscPublicRecord['@miscInformation'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.MiscPublicRecord['@miscInformation'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (miscs|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ fncounsels = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{FinancialCounseling:{} });"" }}
            <div ng-show="fncounsels.length>0">
                <div class="sub_header">
                    Financial Counseling
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Settled:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.FinancialCounseling['@dateSettled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.FinancialCounseling['@dateSettled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.FinancialCounseling['@dateSettled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Amount:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.FinancialCounseling['@amount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.FinancialCounseling['@amount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.FinancialCounseling['@amount']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Court:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@courtName'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fncounsels|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ fnstmts = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{FinancingStatement:{} });"" }}
            <div ng-show="fnstmts.length>0">
                <div class="sub_header">
                    Financial Statement
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Verified:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateVerified']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateVerified']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateVerified']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Industry Type:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.FinancingStatement.CreditorType['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.FinancingStatement.CreditorType['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.FinancingStatement.CreditorType['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Deferred:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.FinancingStatement['@dateMaturity']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.FinancingStatement['@dateMaturity']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.FinancingStatement['@dateMaturity']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (fnstmts|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
            {{ foreclosures = (makeArray(pulblicRecordPartition.PublicRecord)|filter:{Foreclosure:{} });"" }}
            <div ng-show="foreclosures.length>0">
                <div class="sub_header">
                    Fore Closure
                </div>
                <table class="rpt_content_table rpt_content_header rpt_table4column">
                    <tr>
                        <th>
                        </th>
                        <th class="headerTUC">
                            TransUnion
                        </th>
                        <th class="headerEXP" ng-show="{{is3B}}">
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
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Type['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Status['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Filed/Reported:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@dateFiled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Reference#:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord['@referenceNumber'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Date Settled:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Foreclosure['@dateSettled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Foreclosure['@dateSettled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Foreclosure['@dateSettled']|date:'MM/dd/yyyy')||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Liability Amount:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Foreclosure['@liability']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Foreclosure['@liability']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Foreclosure['@liability']|currency)||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                    <tr class="rowAlt">
                        <td class="label">
                            Remarks:
                        </td>
                        <td class="info">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'TUC'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EXP'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                        <td class="info" ng-show="{{is3B}}">
                            <ng-repeat ng-repeat="pulblicRecord in (foreclosures|filter:{Source:{Bureau:{'@symbol':'EQF'}}})">
                                {{(pulblicRecord.Remark.RemarkCode['@description'])||"-"}}
                            </ng-repeat>
                        </td>
                    </tr>
                </table>
            </div>
        </ng>
    </div>
    <div class="content_divider">
    </div>
    <!--Public information ends-->
    <!--Creditor starts-->
    {{ subscribers = makeArray(reports.Subscriber);"" }}
    <div class="rpt_content_wrapper" id="CreditorContacts">
        <div class="rpt_fullReport_header">
            <span class="return_topSpan"><a href="javascript:void(0);" ng-click="scrollTo('reportTop')"
                target="_self" class="moreAboutLink">
                <img src="/images/tu/back_icon.gif">Back to Top </a></span>Creditor Contacts
        </div>
        <table class="help_text">
            <tbody>
                <tr>
                    <td class="help_text_img">
                        <img src="/images/tu/info_icon.gif">
                    </td>
                    <td>
                        The names of people and/or organizations who have obtained a copy of your credit report are listed below.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="rpt_content_table rpt_content_header" ng-if="subscribers.length==0">
            <tr>
                <td class="info">
                    None Reported
                </td>
            </tr>
        </table>
        <table class="rpt_content_table rpt_content_header rpt_content_contacts" ng-if="subscribers.length>0">
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
            <tr ng-class-even="'rowAlt'" ng-repeat="subsr in subscribers">
                <td class="info" width="40%">
                    {{(subsr['@name'])||"-"}}
                </td>
                <td class="info" width="30%">
                    {{subsr.CreditAddress['@unparsedStreet']}}<br /> {{subsr.CreditAddress['@city']|trim}}
                    <span ng-if="subsr.CreditAddress['@stateCode']|trim">,&nbsp;</span>{{subsr.CreditAddress['@stateCode']|trim}}&nbsp;{{subsr.CreditAddress['@postalCode']|zipcode}}
                </td>
                <td class="info" width="30%">
                    {{(subsr['@telephone']|telephone)||"-"}}
                </td>
            </tr>
        </table>
    </div>
    <!--Creditor ends-->
    <div class="rpt_content_wrapper">
        <div class="footer_content ">
            <div class="link_header">
                <a href="javascript:void(0);" ng-click="scrollTo('reportTop')" target="_self" class="moreAboutLink">
                    <img src="/images/tu/back_icon2.gif">Back to Top </a>
                <a href="javascript:void(0);" style="margin-right: 10%;" onclick="return PrintPage()">
                    <img src="/images/tu/print_icon.gif">Print this page </a>
                <a class="imgDownloadAction" href="javascript:void(0);" onclick="generateCreditReport()">
                    <img src="/images/tu/download.jpg" />Download this report</a>
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
                    height: 18px;" ng-model="selectedHistory" ng-options="hry.Id as hry.Date for hry in reportHistory track by hry.Id" ng-change="reportHistoryChanged()">
                </select>
            </div>
        </div>
    </div>
    <br />
    <span style="color: Red;">You have an issue with viewing your Credit Report <ng ng-if="selectedHistory&&selectedHistory.Id">- {{activeReportReference}}</ng>. Please
        contact customer service</span><br>
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
                        60 Days Late
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
                        **Sometimes the credit bureaus do not have information from a particular month on file.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="clear">
    </div>
</div>