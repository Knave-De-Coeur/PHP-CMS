<?php
/**
 * Created by PhpStorm.
 * User: knave-de-coeur
 * Date: 03/10/18
 * Time: 16:59
 */
?>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <h2>Are you sure you want to delete this post?</h2>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="modal_delete_link" value="" name="delete_id">
                <input type="submit" class="btn btn-danger" value="Delete" name="delete">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>
