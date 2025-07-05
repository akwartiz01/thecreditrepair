<?php foreach ($tasks_current as $task) { ?>
<tr>
  <td>
    <input type="checkbox" class="form-check-input m-0 task-status-toggle" data-task-id="<?= $task->id ?>" checked />
    <label class="ml-4"><?= $task->subject ?></label>
  </td>
  <td><a href="<?= base_url(); ?>dashboard/<?= get_encoded_id($task->sq_client_id); ?>" target="_blank" class="text-primary text-decoration-underline"><?= $task->sq_first_name . ' ' . $task->sq_last_name ?></a></td>
  <td><?= $task->team_member_id ?></td>
  <td class="text-danger">
    <?php
      $dueDate = new DateTime($task->due_date);
      $today = new DateTime();
      echo ($dueDate < $today)
        ? $dueDate->diff($today)->days . ' days overdue'
        : 'Due on ' . $dueDate->format('d M Y');
    ?>
  </td>
  <td>
    <div class="d-flex gap-2">
      <a class="btn btn-sm btn-link p-0 mx-2 edit-tasks" data-id="<?= $task->id ?>"
      data-subject="<?= htmlspecialchars($task->subject) ?>"
      data-type="<?= htmlspecialchars($task->task_type) ?>"
      data-due="<?= $task->due_date ?>"
             data-time="<?= $task->due_time ?>"
      data-member="<?= htmlspecialchars($task->team_member_id) ?>"
      data-notes="<?= htmlspecialchars($task->notes) ?>" data-name="complete">Edit</a>
      <a class="btn btn-sm btn-link text-danger p-0 mx-2 delete-tasks" data-id="<?= $task->id ?>" data-name="complete">Delete</a>
    </div>
  </td>
</tr>
<?php } ?>
