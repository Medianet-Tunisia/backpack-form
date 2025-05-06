@php
    $id = $entry->getKey();
@endphp

<a href="{{ url($crud->route.'/'.$id.'/show') }}" class="btn btn-sm btn-link"><i class="la la-eye"></i></a>
<a href="{{ url($crud->route.'/'.$id.'/edit') }}" class="btn btn-sm btn-link"><i class="la la-edit"></i></a>

<form method="POST" action="{{ url($crud->route.'/'.$id) }}" style="display:inline;" onsubmit="return confirm('Confirmer la suppression ?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-link text-danger"><i class="la la-trash"></i></button>
</form>
