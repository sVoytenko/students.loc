<?php require 'header.php'; ?>
<div class="container-fluid">
    <table class="table">
        <tr>
            <td> <a href="/?sort=name<?php echo htmlspecialchars(Util::getUnsortedLink()) ?>">Имя</a></td>
            <td> <a href="/?sort=second_name<?php echo htmlspecialchars(Util::getUnsortedLink()) ?>">Фамилия</a></td>
            <td> <a href="/?sort=group_number<?php echo htmlspecialchars(Util::getUnsortedLink()) ?>">Группа</a></td>
            <td> <a href="/?sort=summary<?php echo htmlspecialchars(Util::getUnsortedLink()) ?>">Сумарный балл</a></td>
        </tr>
        <?php foreach ($model as $student) : ?>
            <tr>
                <td> <?php echo htmlspecialchars($student->name); ?></td>
                <td> <?php echo htmlspecialchars($student->second_name); ?></td>
                <td> <?php echo htmlspecialchars($student->group_number); ?></td>
                <td> <?php echo htmlspecialchars($student->summary); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<script src="js/search.js"></script>
<?php require 'footer.php'; ?>