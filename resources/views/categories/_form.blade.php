
<div class="form.group">
  <input type="text" class="form-control" name="title" value="{{ $category ->name ?? 'нет'}}" placeholder="Наименование категории">
</div>
<div class="form.group">
  <select name="parent_id" class="form-control">
    <option value="0">-- без родительской категории --</option>
    @include('categories._categories')
  </select>
</div>

<hr>

<button type="submit">Сохранить</button>