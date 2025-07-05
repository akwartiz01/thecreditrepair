<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<style>

    #sc-iframe {
        margin: 0;
        padding: 0;
        z-index: 1;
        width: 100%;
        height: 100vh;
        border: none;
        overflow: hidden;
    }
</style>

<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="page-header">

            <div class="row">

                <div class="col">

                    <h3 class="page-title">Credit Reports</h3>

                </div>

                <div class="col-auto text-right">

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
        <iframe id="sc-iframe" src="https://wgt.stitchcredit.com/login-direct?key=0f55847b-3d2f-483d-b387-82dc4c0847cc&ocf=536877043&oct=EF4D7E"></iframe>

                <!--<iframe id="sc-iframe" src="https://efx-dev.stitchcredit.com/login-aio?key=6a405259-4075-45cc-8455-2b60d213a9fe"></iframe>-->
            </div>

        </div>

    </div>

</div>


<script>
    //this just throws in a default ID if one isn't provided on the query string
    // const id = document.location.search.length > 0 ? document.location.search.split('&')[0].split('=')[1] :
    //     '5b5cf0ad-6f7a-4ae5-bba7-8203a17958ba';
    // console.log("ID: ", id);
    console.log("Loading Message Listener...");

    window.addEventListener("message", receiveMessage, false);

    function receiveMessage(event) {
        if (event && event.source && event.data) {
            // You only need to implement the types that are important/relevant to your use case.
             if (event.data.type === 'AUTH_REQUIRED') {
                const es = event.source;
                //this code uses a test endpoint on the server to provide a preauth-token for any user ID without the usual hurdles.
                //This is ONLY for testing and does not exist in the production environment.
                // getData("https://wgt.stitchcredit.com/api/test/preauth-token/" + id, function() {
                    es.postMessage({
                        type: "PREAUTH",
                        token: "<?= $paToken; ?>"
                    }, "*");
             
            } else if (event.data.type === 'REG_STARTED') {
                const es = event.source;
                //only valid for full web implementation, Direct API already creates the customer, so this will never happen in those instances
                // (new Date().valueOf()) - is used to generate a new email ID on the fly for testing purposes
                es.postMessage({
                    type: 'REG',
                    data: {
                        fname: "",
                        lname: "",
                        email: "test+" + (new Date().valueOf()) + "@test.com"
                    }
                }, "*");
            } else if (event.data.type === 'IDENTITY_STARTED') {
                const es = event.source;
                //You could use this function to pre-populate the given fields.  DoB and SSN will never be prepopulated as it violates compliance
                // new Date().valueOf().toString() - generates a unique number for street2 to ensure each run goes through the full identity process, remove to test sequential sign up of the same user
                es.postMessage({
                    type: 'IDENTITY',
                    data: {
                        street1: "",
                        street2: new Date().valueOf().toString(),
                        city: "",
                        state: "",
                        zip: "",
                        mobile: ""
                    }
                }, "*");
            } else if (event.data.type === 'LOGIN_SUCCESSFUL') {
                console.log("User succesfully logged in");
            } else if (event.data.type === 'LOGIN_FAILED') {
                //if you see this message more than a few times in a row, it's likely an issue
                //typically this will only occur for full web implementations, not Direct API
                console.log("User login failed");
            } else if (event.data.type === 'USER_ENROLLED') {
                //User successfully completed identity and has been enrolled for consumer data
                console.log("User enrollment successful");
            } else if (event.data.type === 'IDENTITY_FAILED') {
                //Identity process failed, user is likely "stuck" as they cannot continue
                console.log("User identity failure");
            } else if (event.data.type === 'SERVICE_FAILURE') {
                //Identity process failed most likely due to a service outage, but the user is stuck as they cannot continue without passing identity
                console.log("Identity service failure");
            }
        }

        function getData(req, action) {
            var xhr = new XMLHttpRequest();
            xhr.responesType = 'json';
            xhr.onload = action;
            xhr.open("GET", req);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send();
        }

    }
</script>