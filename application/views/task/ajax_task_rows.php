<?php
$today = new DateTime();
$today->setTime(0, 0, 0);

// Grouping tasks
$grouped_tasks = [
  'Overdue' => [],
  'Today' => [],
  'Upcoming' => [],
];

foreach ($tasks_current as $task) {
    $dueDate = new DateTime($task->due_date);
    if ($dueDate < $today) {
        $grouped_tasks['Overdue'][] = $task;
    } elseif ($dueDate->format('Y-m-d') === $today->format('Y-m-d')) {
        $grouped_tasks['Today'][] = $task;
    } else {
        $grouped_tasks['Upcoming'][] = $task;
    }
}
?>

<?php foreach ($grouped_tasks as $group => $tasks): ?>
  <?php if (!empty($tasks)): ?>
  
    <tr>
     <?php if($group == "Overdue") { ?>  
        <th colspan="5" class="bg-danger text-white"><b><?= $group ?></b></th>
        <?php } ?>
         <?php if($group == "Today") { ?>  
        <th colspan="5" class="text-white" 
    style="background: green"><b><?= $group ?></b></th>
        <?php } ?>
         <?php if($group == "Upcoming") { ?>  
        <th colspan="5" class="bg-warning text-white"><b><?= $group ?></b></th>
        <?php } ?>
        </tr>
    <?php foreach ($tasks as $task): ?>
      <tr>
        <td>
          <input type="checkbox" class="form-check-input m-0 task-status-toggle"
                 data-task-id="<?= $task->id ?>"
                 <?= ($task->task_status == 'completed') ? 'checked' : '' ?> />
          <label class="ml-4"><?= $task->subject ?></label>
        </td>
        <td>
          <a href="<?= base_url(); ?>dashboard/<?= get_encoded_id($task->sq_client_id); ?>" target="_blank"
             class="text-primary text-decoration-underline">
             <?= $task->sq_first_name . ' ' . $task->sq_last_name ?>
          </a>
        </td>
        <td><?= $task->team_member_id ?></td>

        <?php
          $dueDate = new DateTime($task->due_date);
          $class = 'text-body';
          if ($group === 'Overdue') {
              $text = $dueDate->diff($today)->days . ' days overdue';
              $class = 'text-danger';
          } elseif ($group === 'Today') {
              $text = 'Today';
          } else {
              $text = $dueDate->format('d M Y');
          }
        ?>
        <td class="<?= $class ?>"><?= $text ?></td>

        <td>
          <div class="d-flex gap-2">
            <a class="btn btn-sm btn-link p-0 mx-2 edit-tasks"
               data-id="<?= $task->id ?>"
              data-subject="<?= htmlspecialchars($task->subject) ?>"
      data-type="<?= htmlspecialchars($task->task_type) ?>"
      data-due="<?= $task->due_date ?>"
      data-member="<?= $task->team_member_id ?>"
        data-time="<?= $task->due_time ?>"
      data-notes="<?= htmlspecialchars($task->notes) ?>"
               data-name="current">Edit</a>
            <a class="btn btn-sm btn-link text-danger p-0 mx-2 delete-tasks"
               data-id="<?= $task->id ?>"
               data-name="current">Delete</a>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
<?php endforeach; ?>
