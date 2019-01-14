<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" >
    <button>Send</button>
</form>
<hr>

<form action="uploadm.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="files[]" multiple>
    <button>Send Multiple</button>
</form>