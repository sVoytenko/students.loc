<?php require 'header.php'; ?>
<div class="container-fluid">
    <?php if (isset($data['notify'])): ?>
    <div class="alert-info">Спасибо за регистрацию!</div>
    <?php endif; ?>
    
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
                <td> <?php echo htmlspecialchars($student->secondName); ?></td>
                <td> <?php echo htmlspecialchars($student->groupNumber); ?></td>
                <td> <?php echo htmlspecialchars($student->summary); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($page = 1; $page <= $data['totalPages']; $page++) : ?>
            <li><a href="<?php echo htmlspecialchars(Util::getSortedLink($page)) ?>"><?php echo $page ?></a></li>
        <?php endfor; ?>
    </ul>
</nav>
<?php require 'footer.php'; ?>