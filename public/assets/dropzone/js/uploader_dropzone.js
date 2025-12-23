/* ------------------------------------------------------------------------------
 *
 *  # Dropzone multiple file uploader
 *
 *  Demo JS code for uploader_dropzone.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DropzoneUploader = function() {


    //
    // Setup module components
    //

    // Dropzone file uploader
    const _componentDropzone = function() {
        if (typeof Dropzone == 'undefined') {
            console.warn('Warning - dropzone.min.js is not loaded.');
            return;
        }

       

        


       

        // File limitations
        let dropzoneFileLimits = new Dropzone("#dropzone_file_limits", {
            url: "#",
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 0.4, // MB
            maxFiles: 10,
            maxThumbnailFilesize: 1,
            addRemoveLinks: true
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDropzone();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DropzoneUploader.init();
});
