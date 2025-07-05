
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Web Lead Form</h3>
                </div>
 
            </div>
        </div>


<div class="card shadow-sm rounded-4">
  <div class="card-body">
    <!-- Language Selection -->
    <div class="mb-3">
      <label class="form-label d-block">Select Language:</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="language" id="english" value="english" checked>
        <label class="form-check-label" for="english">English</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="language" id="spanish" value="spanish">
        <label class="form-check-label" for="spanish">Spanish</label>
      </div>
    </div>

    <!-- Custom Title -->
    <div class="mb-3">
      <label for="customTitle" class="form-label">Webform Custom Title</label>
      <input type="text" class="form-control" id="customTitle" placeholder="Enter title">
    </div>

    <!-- Frame Size -->
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="frameHeight" class="form-label">Frame Height</label>
        <input type="text" class="form-control" id="frameHeight" placeholder="e.g., 600px">
      </div>
      <div class="col-md-6 mb-3">
        <label for="frameWidth" class="form-label">Frame Width</label>
        <input type="text" class="form-control" id="frameWidth" placeholder="e.g., 100%">
      </div>
    </div>

    <!-- Webform Code -->
    <div class="mb-3">
      <label for="webformCode" class="form-label">Webform Code</label>
      <textarea class="form-control" id="webformCode" rows="5" placeholder="Paste your embed code here..."></textarea>
    </div>

    <!-- Preview Button -->
    <button type="button" class="btn btn-primary" onclick="previewIframe()">Preview</button>
  </div>
</div>
  <!-- Preview Output -->
    <div id="previewContainer" class="mt-4 border p-3 rounded bg-light d-none">
      <h6 class="mb-3">Live Preview:</h6>
      <div id="iframePreview"></div>
    </div>
    </div>
</div>
<script>
  function previewIframe() {
    const code = document.getElementById("webformCode").value;
    const previewContainer = document.getElementById("previewContainer");
    const iframePreview = document.getElementById("iframePreview");

    // Basic sanitization (optional: use a sanitizer lib for production)
    if (code.includes("<iframe")) {
      iframePreview.innerHTML = code;
      previewContainer.classList.remove("d-none");
    } else {
      iframePreview.innerHTML = "<p class='text-danger'>Please enter a valid iframe code.</p>";
      previewContainer.classList.remove("d-none");
    }
  }
</script>