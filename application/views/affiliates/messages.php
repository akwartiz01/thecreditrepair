<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Messages</h3>
                </div>
 
            </div>
        </div>

        <div class="card shadow-sm">
  <div class="card-body">
    <div class="row">
      
      <!-- Left Sidebar: Message List + Search -->
      <div class="col-md-4 border-end" style="height: 500px; overflow-y: auto;">
        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Search messages...">
        </div>

        <ul class="list-group d-none">
          <!-- Example Messages -->
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-bold">John Doe</div>
              <small class="text-muted">Hey, how are you?</small>
            </div>
            <span class="badge bg-primary rounded-pill">2</span>
          </li>
          <li class="list-group-item">
            <div class="fw-bold">Jane Smith</div>
            <small class="text-muted">Let's catch up tomorrow.</small>
          </li>
          <!-- Add dynamically -->
        </ul>
      </div>

      <!-- Right Side: Conversation + New Message -->
      <div class="col-md-8 d-flex flex-column" style="height: 500px;">
        
        <!-- Top Bar with New Message Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Messages</h5>
          <button class="btn btn-primary btn-sm">+ New Message</button>
        </div>

        <!-- Conversation Area -->
        <div class="flex-grow-1 border p-3 rounded bg-light d-none" style="overflow-y: auto;">
          <!-- Example Message -->
          <div class="mb-2">
            <strong>You:</strong>
            <div class="bg-white p-2 rounded shadow-sm mt-1">Hello, John!</div>
          </div>
          <div class="mb-2">
            <strong>John:</strong>
            <div class="bg-white p-2 rounded shadow-sm mt-1">Hi! How’s it going?</div>
          </div>
          <!-- Dynamically Load More -->
        </div>

        <!-- Message Input -->
        <div class="mt-3 d-none">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Type your message...">
            <button class="btn btn-primary">Send</button>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

    </div>
</div>