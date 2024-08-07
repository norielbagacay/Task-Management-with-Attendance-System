<!-- editModal.php -->
<div class="modal fade" id="editModal<?php echo $task['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Task Form -->
                <form action="?pg=edit_task" method="POST">
                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                    <div class="form-group">
                        <label for="edit_task_title">Title</label>
                        <input type="text" class="form-control" id="edit_task_title" name="edit_task_title" value="<?php echo $task['title']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="edit_task_description">Description</label>
                        <textarea class="form-control" id="edit_task_description" name="edit_task_description"><?php echo $task['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_task_priority">Priority</label>
                        <select class="form-control" id="edit_task_priority" name="edit_task_priority">
                            <option value="high" <?php echo ($task['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
                            <option value="medium" <?php echo ($task['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="low" <?php echo ($task['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_task_status">Status</label>
                        <select class="form-control" id="edit_task_status" name="edit_task_status">
                            <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="in progress" <?php echo ($task['status'] == 'in progress') ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
