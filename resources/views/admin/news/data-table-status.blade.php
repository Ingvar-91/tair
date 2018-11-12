@if($status == 0)
<span class="text-warning">На утверждении</span>
@endif

@if($status == 1)
<span class="text-success">Опубликовано</span>
@endif

@if($status == 2)
<span class="text-muted">Черновик</span>
@endif
