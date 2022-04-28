<div class="col-md-12">
    @if (session()->has('code'))
        <div class="alert alert-{{ session()->get('color') }}">
            <small>{{ session()->get('msg') }}</small>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
</div>
