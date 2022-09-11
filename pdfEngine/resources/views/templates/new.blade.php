@include('main.head')
@include('main.topmenu')
<div class="row">
    <div class="col text-secondary"><h5>New Template</h5></div>
</div>
<div class="row justify-content-center">

    <div class="col-sm-6 shadow rounded">
        <div class="mb-3">
            <form action="" method="post">
                @csrf
                <label for="templatename" class="form-label">Templatename</label>
                <input class="form-control" type="text" id="templatename" name="templatename">
                <button type="submit" class="btn btn-outline-success  m-3 float-end"><i class="bi bi-check2"></i> Create</a>
              </div>
            </form>
    </div>

@include('main.foot')
