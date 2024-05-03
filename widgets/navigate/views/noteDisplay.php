<div class="form-group d-grid gap-2 d-md-flex justify-content-end" style="margin-top: -55px;">
    <div class="btn-group p-2" role="group" aria-label="Basic example">
        <a href="/note/display?as=table"
           type="button"
           class="btn btn-light <?php echo (empty($_SESSION['noteDisplay']) || $_SESSION['noteDisplay'] != 'msg' ? 'active' : ''); ?>"><i class="fas fa-list"></i></a>
        <a href="/note/display?as=msg"
           type="button"
           class="btn btn-light <?php echo (!empty($_SESSION['noteDisplay']) && $_SESSION['noteDisplay'] == 'msg' ? 'active' : ''); ?>"><i class="far fa-list-alt"></i></a>
    </div>
</div>