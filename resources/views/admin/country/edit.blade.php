
{!! Form::open(array('route' => ['countries.update',$country->id],'class'=>'form-horizontal','method'=>'PUT','role'=>'form')) !!}
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Edit Country Name</h4>
        <button type="button" class="close" data-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="form-group row">

            <div class="col-md-4">
                <input type="text" class="form-control" name="name" value="{{old('name',$country->name)}}" placeholder="Type Country Name Here">
                <small>Country Name</small>
            </div>
            <div class="col-md-3">
                {{Form::select('status', $status, $country->status, ['class' => 'form-control'])}}
                <small> Status </small>
            </div>
            <div class="col-md-2">
                <?php $max=$max_serial+1; ?>
                {{Form::number('serial_num',$country->serial_num,['class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0','required'=>true])}}
                <small> Serial </small>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
    </div>
</div>
{!! Form::close(); !!}


