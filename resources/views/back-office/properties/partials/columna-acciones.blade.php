<ul class="list-inline font-size-20 contact-links mb-0">
    <li class="list-inline-item">
        <a href="/contratos/contratos-propiedad/{{ $propiedad->id }}" data-toggle="tooltip" data-placement="top" title="Contratos"><i class="bx bxs-file"></i></a>
    </li>
    <li class="list-inline-item">
        <a href="/mandatos/mandatos-propiedad/{{ $propiedad->id }}" data-toggle="tooltip" data-placement="top" title="Mandatos"><i class="bx bxs-spreadsheet"></i></a>
    </li>
    <li class="list-inline-item">
        <a href="/properties/edit/{{ $propiedad->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
    </li>
    <li class="list-inline-item">
        <form id="form1-{{ $propiedad->id }}" action="{{ url('/properties/destroy') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $propiedad->id }}"/>
            <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
        </form>
    </li>
    <li class="list-inline-item">
        <form id="form2-{{ $propiedad->id }}" action="{{ url('/properties/duplicar') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $propiedad->id }}"/>
            <button style="border: 0px; background-color: white;" type="submit"><i class="fa fa-clone"></i></button>
        </form>
    </li>
</ul>
