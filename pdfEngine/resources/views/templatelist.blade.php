@include('main.head')
@include('main.topmenu')
<div class="row">
    <div class="col text-secondary"><h5>Templates</h5></div>
</div>
<div class="row p-2 rounded shadow">
    <div class="col">
        <div class="row">
            <div class="col"></div>
            <div class="col text-end">
                <a href="{{route('newtemplate')}}" class="btn btn-outline-success"><i class="bi bi-file-earmark-plus"></i> New</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col"></div>
            <div class="col text-end">
            <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
             @if ($templates->currentPage() != 1)
             <a href="{{$templates->previousPageUrl()}}" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i></a>
             @endif
             <div class="btn-outline-dark">{{$templates->currentPage()}}/{{$templates->lastPage()}}</div>
             @if ($templates->currentPage() != $templates->lastPage())
             <a href="{{$templates->nextPageUrl()}}" class="btn btn-outline-dark"><i class="bi bi-arrow-right"></i></a>
             @endif
            </div>
            </div>
        </div>
        <div class="row p-2">
 @foreach ($templates as $template)
<div class="col-12 border rounded p-2 mt-2">
    <div class="row">
    <div class="col"><h5>{{$template->templatename}}</h5></div><div class="col">Created: {{$template->created_at}}</div>
    <div class="col">API Url: <input type="text" readonly value="{{route('templaterender',$template->templatename)}}"><a class="btn" onclick="Clipboard('{{route('templaterender',$template->templatename)}}')"><i class="bi bi-clipboard"></i></a></div>
    <div class="col text-end">
        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
            <button type="button" class="btn btn-outline-dark"><i class="bi bi-eye"></i></button>
            <a class="btn btn-outline-dark" href="{{route('edittemplate',$template->templatename)}}"><i class="bi bi-pencil"></i></a>
            <button type="button" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button>
          </div>
        </div>
</div>
</div>
@endforeach
</div>
        <div class="row mt-2">
            <div class="col"></div>
            <div class="col text-end">
            <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
             @if ($templates->currentPage() != 1)
             <a href="{{$templates->previousPageUrl()}}" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i></a>
             @endif
             <div class="btn-outline-dark">{{$templates->currentPage()}}/{{$templates->lastPage()}}</div>
             @if ($templates->currentPage() != $templates->lastPage())
             <a href="{{$templates->nextPageUrl()}}" class="btn btn-outline-dark"><i class="bi bi-arrow-right"></i></a>
             @endif
            </div>
            </div>
        </div>
    </div>
</div>
<script>
    function Clipboard(value){
        navigator.clipboard.writeText(value);
        alert('Copied API-Url to Clipboard!');
    }

</script>
@include('main.foot')
