@if(!$menu->parent_id)
<div class="action">
    <a class="magnum-jstree-create magnum-ajax" href="{{ route('admin.page.add.item',['page' => $menu->id]) }}">
        <span class="bx bx-plus"></span>
        Create
    </a>
</div>
@endif
<div class="action">
    <a class="" href="{{ !$menu->parent_id? route('admin.menu.page.edit',['page' => $menu->id]):route('admin.page.update.item',['page' => $menu->parent_id,'id' => $menu->id]) }}">
        <span class="bx bx-edit"></span>
        Edit
    </a>
</div>
<div class="action">
    <a class="magnum-delete magnum-ajax" href="{{ route('admin.page.delete',['page' => $menu->id]) }}">
        <span class="bx bx-trash"></span>
        Delete
    </a>
</div>
<div class="action">
    <a class="magnum-togglevisibility magnum-ajax" href="{{ route('admin.page.show-hide',['page' => $menu->id]) }}">
        <span class="bx bx-show"></span>
        Show / Hide
    </a>
</div>
