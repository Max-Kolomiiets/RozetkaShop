<style>
    .ext-icon {
        color: rgba(0,0,0,0.5);
        margin-left: 10px;
    }
    .installed {
        color: #00a65a;
        margin-right: 10px;
    }
</style>

<h3 class="text-center">You can upload JSON file with products</h3>
<form method="POST" id="upload_products" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="inputFile">Select File:</label>
        <input 
            type="file" 
            name="file" 
            id="inputFile"
            class="form-control">
        <span class="text-danger" id="file-input-error"></span>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-success">Upload</button>
    </div>
</form>