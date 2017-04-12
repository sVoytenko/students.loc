<?php require 'header.php'; ?>
<?php if (!empty($data['errors'])): ?>
    <div class="alert-warning">
        <?php foreach ($data['errors'] as $error): ?>
            <?php echo $error . '<br>'; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php print_r($model->gender) ?>
<form class="form-horizontal" name="name" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" >
    <p> Имя <input type="text" name="name" required value="<?php echo $model->name; ?>"> </p>
    <p> Фамилия <input type="text" name="second_name" required value="<?php echo $model->secondName; ?>"> </p>
    <p> Пол <select name="gender" required>
            <?php if (!empty($model->gender)): ?>
                <option selected value="<?php echo htmlspecialchars($model->gender); ?>"><?php echo htmlspecialchars($model->gender) ?></option>
            <?php endif; ?>
            <option value="Мужской">Мужской</option>
            <option value="Женский">Женский</option>
        </select>
    </p>
    <p> Номер вашей группы <input type="text" name="group_number" required value="<?php echo $model->groupNumber; ?>"> </p>
    <p> Год рождения <input type="text" name="birth_year" required pattern="^[ 0-9]+$" value="<?php echo $model->birthYear; ?>"> </p>
    <p> Сумарный бал <input type="text" name="sumary" required pattern="^[ 0-9]+$" value="<?php echo $model->summary; ?>"> </p>
    <p> Электронный адрес <input type="email" name="email" required value="<?php echo $model->email; ?>"> </p>
    <p> Вы местный? <select name="local" required>
            <?php if (!empty($model->local)): ?>
                <option selected value="<?php echo htmlspecialchars($model->local); ?>"><?php echo htmlspecialchars($model->local) ?></option>
            <?php endif; ?>
            <option value="Да">Да</option>
            <option value="Нет">Нет</option>
        </select>
        <input type="submit" value="Зарегистрироваться">
</form>
<?php require 'footer.php'; ?>