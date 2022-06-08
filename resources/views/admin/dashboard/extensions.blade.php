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
{{-- <form method="POST" id="upload_products" enctype="multipart/form-data">
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
</form> --}}

<form id="multiple-image-upload-preview-ajax" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
    @csrf
            
      <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                  <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="images" name="images[]" multiple="">
                    <label class="custom-file-label" for="inputGroupFile01">Choose Multiple Images</label>
                  </div>
                </div>
              </div>
          </div>                
          <div class="col-md-12">
              <div class="mt-1 text-center">
                  <div class="preview-image"> </div>
              </div>  
          </div>

          <div class="mb-3 mt-3">
            <label class="form-label" for="inputFile">Select JSON File:</label>
            <input 
                type="file" 
                name="file" 
                id="inputJsonFile"
                class="form-control">
            <span class="text-danger" id="file-input-error"></span>
        </div>

          <div class="col-md-12">
              <button type="submit" class="btn btn-primary" id="submit">Submit</button>
          </div>
      </div>     
  </form>