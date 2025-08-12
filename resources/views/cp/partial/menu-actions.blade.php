<div class="action">
    <a class="magnum-jstree-create magnum-ajax" href="{{ route('admin.menu.add.content',['menu' => $menu->id]) }}">
        <span class="bx bx-plus"></span>
        Create
    </a>
</div>
<div class="action">
    <a class="" href="{{ route('admin.menu.edit',['menu' => $menu->id]) }}">
        <span class="bx bx-edit"></span>
        Edit
    </a>
</div>
<div class="action">
    <a class="magnum-delete magnum-ajax" href="{{ route('admin.menu.delete',['menu' => $menu->id]) }}">
        <span class="bx bx-trash"></span>
        Delete
    </a>
</div>
<div class="action">
    <a class="magnum-togglevisibility magnum-ajax" href="{{ route('admin.menu.show-hide',['menu' => $menu->id]) }}">
        <span class="bx bx-show"></span>
        Show / Hide
    </a>
</div>
