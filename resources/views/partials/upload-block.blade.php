<div role="upload-block" class="upload-block">

    <div role="upload_pre_loader" class="pre-loader absolute">
        <div class="loader-small"></div>
        <div class="loader-big"></div>
    </div>

    <div class="preview-block">
        <div role="preview_pre_loader" class="pre-loader absolute">
            <div class="loader-small"></div>
            <div class="loader-big"></div>
        </div>
        <div role="file_preview" class="file-preview">PREVIEW</div>
    </div>

    <form role="upload-form" class="upload-form" onsubmit="submitUploadForm(event)">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">

        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">Alt</span>
            </div>
            <input type="text" role="alt" name="data[alt]" class="form-control" placeholder="Alt" aria-label="Alt">
            <div role="validation_alt_feedback" class="invalid-feedback"></div>
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">Title</span>
            </div>
            <input type="text" role="title" name="data[title]" class="form-control" placeholder="Title" aria-label="Title">
            <div role="validation_title_feedback" class="invalid-feedback"></div>
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">Description</span>
            </div>
            <textarea role="description" name="data[description]" class="form-control" aria-label="Description"></textarea>
            <div role="validation_description_feedback" class="invalid-feedback"></div>
        </div>
        <div class="input-group mb-2 file-section">
            <div class="input-group-prepend">
                <span class="input-group-text">File</span>
            </div>
            <input type="file" role="file" name="file" class="form-control" placeholder="New file">
            <div class="input-group-append">
                <button class="btn btn-primary ml-1" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383"/>
                        <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z"/>
                    </svg>
                    <span>Upload</span>
                </button>
                <button class="btn btn-warning ml-1 through" type="button" onclick="cancelUploadBlock(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                    <span>Cancel</span>
                </button>
            </div>
            <div role="validation_file_feedback" class="invalid-feedback"></div>
        </div>
    </form>
</div>
