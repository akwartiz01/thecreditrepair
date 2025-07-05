<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">My Referrals</h3>
                </div>
 
            </div>
        </div>


<div class="card shadow-sm rounded-4 mt-4">
  <div class="card-body">
    <h5 class="card-title mb-4">Search My Clients</h5>

    <!-- Search Form -->
    <form id="clientSearchForm" onsubmit="searchClients(event)">
      <div class="row g-3">
        <div class="col-md-4 mb-3">
          <input type="text" class="form-control" id="name" placeholder="Search by Name">
        </div>
        <div class="col-md-4 mb-3">
          <input type="email" class="form-control" id="email" placeholder="Search by Email">
        </div>
        <div class="col-md-4 mb-3">
          <select class="form-control" id="status">
            <option value="">Select Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
          </select>
        </div>
      </div>

      <div class="mt-3">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

    <!-- Results Table -->
    <div class="mt-4">
        
      <table class="table table-bordered table-hover jsgrid" id="resultsTable">
        <thead class="thead-dark">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="resultsBody">
          <!-- Data rows will appear here -->
        </tbody>
      </table>
      <div id="noResults" class="text-center text-muted mt-3">No record found.</div>
    </div>
  </div>
</div>


    </div>
</div>
<script>
  function searchClients(event) {
  event.preventDefault();

  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const status = document.getElementById("status").value;

  $.ajax({
    url: "<?php echo base_url('affiliate/search_clients'); ?>",
    type: "POST",
    dataType: "json",
    data: {
      name: name,
      email: email,
      status: status
    },
    success: function(response) {
      const resultsBody = document.getElementById("resultsBody");
      const noResults = document.getElementById("noResults");
      resultsBody.innerHTML = "";
console.log(response.status);
      if (response.status === "success" && response.clients && response.clients.length > 0) {
    response.clients.forEach(client => {
      const fullName = `${client.sq_first_name ?? ''} ${client.sq_last_name ?? ''}`.trim();
      const row = `
        <tr>
          <td>${fullName}</td>
          <td>${client.sq_email ?? ''}</td>
          <td>${client.status ? client.status.charAt(0).toUpperCase() + client.status.slice(1) : 'N/A'}</td>
        </tr>`;
      resultsBody.insertAdjacentHTML('beforeend', row);
    });
    noResults.classList.add("d-none");
  } else {
    noResults.classList.remove("d-none");
  }
    },
    error: function(xhr) {
      console.error("Error:", xhr.responseText);
      alert("Failed to fetch client data.");
    }
  });
}

</script>
