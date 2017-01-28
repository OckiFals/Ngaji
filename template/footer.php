<footer class="main-footer">
    <div class="container-fluid">
        <div class="pull-right hidden-xs">
            <a>Made By <i>Ngaji 2.1, AngularJS</i> and <i class="fa fa-heart"></i></a>
        </div>
        <strong>Copyright &copy;<a>My Company</a>.</strong> All
        rights reserved.
    </div>
    <!-- /.container -->
</footer>

<!-- jQuery 2.1.3 -->
<?php echo Html::load('js', 'jquery.min.js') ?>
<!-- Bootstrap 3.3.2 JS -->
<?php echo Html::load('js', 'bootstrap.min.js') ?>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmation Delete</h4>
            </div>
            <div class="modal-body">
                Are you sure to delete <span id="type-modal"> </span> post <strong id="post_title"> </strong> #id=<span id="post_id"> </span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-flat btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $('#confirm-delete').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget); // Button that triggered the modal
        var type = button.data('type-modal'); // Extract post id from data-name attribute
        var id = button.data('post-id'); // Extract post id from data-name attribute
        var title = button.data('post-title'); // Extract post id from data-name attribute

        var modal = $(this);
        modal.find('#post_id').text(id);
        modal.find('#type-modal').text(type);
        modal.find('#post_title').text(title);

        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
