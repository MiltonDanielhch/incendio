@props([
    'id', 'name', 'label', 'options', 'selected' => '',
    'parent' => null, 'route' => '', 'disabled' => false
])
<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $id }}" class="form-control" {{ $disabled ? 'disabled' : '' }} required>
        <option value="">{{ $disabled ? 'Seleccione primero ' . $parent : 'Seleccione una opción' }}</option>
        @foreach($options as $opt)
            <x-option-selected :value="$opt->id" :selected="$selected">{{ $opt->nombre }}</x-option-selected>
        @endforeach
    </select>
</div>

{{-- @once
@push('javascript')
<script>
(function(){
    // ✅ CORRECCIÓN DEFINITIVA: Obtenemos la URL base correctamente
    const baseUrl = '{{ $route }}';
    const parentId = '{{ $parent }}';
    const childId  = '{{ $id }}';

    // Verificamos que tengamos los elementos necesarios
    if (!parentId || !childId) return;

    const $parent = $('#' + parentId);
    const $child  = $('#' + childId);

    if (!$parent.length || !$child.length) return;

    $parent.change(function(){
        const id = $(this).val();
        $child.prop('disabled', true).html('<option>Cargando...</option>');

        if (!id) {
            $child.html('<option>Seleccione primero ' + $parent.find('option:first').text() + '</option>');
            return;
        }

        // ✅ CONSTRUCCIÓN CORRECTA DE LA URL
        const url = baseUrl + '/' + id;

        $.getJSON(url, function(data) {
            let html = '<option value="">Seleccione una opción</option>';
            $.each(data, (_, item) => {
                html += `<option value="${item.id}">${item.nombre}</option>`;
            });
            $child.html(html).prop('disabled', false);
        }).fail(() => {
            $child.html('<option>Error al cargar</option>');
        });
    });
})();
</script>
@endpush
@endonce
 --}}
