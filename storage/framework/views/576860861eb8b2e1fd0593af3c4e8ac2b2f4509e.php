<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="<?php echo e(route('send.message')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <label><span class="fas fa-paperclip"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept="image/*, .txt, .rar, .zip, .pdf, .csv, .doc, .docx, .odt, .xls, .xlsx, .ods, .ppt, .pptx" /></label>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button disabled='disabled'><span class="fas fa-paper-plane"></span></button>
    </form>
</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/vendor/Chatify/layouts/sendForm.blade.php ENDPATH**/ ?>