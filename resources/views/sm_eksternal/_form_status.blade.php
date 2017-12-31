
<div class= "form-group{{ $errors->has('tgl_status') ? 'has-error': '' }} ">
    {!! Form::label('tgl_status', 'Tanggal ', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {{ Form::text('tgl_status','', array ('id' => 'datepicker')) }}
        {!! $errors->first('tgl_status', '<p class= "help-block">:message</p>') !!}        
    </div>
</div>

<div class= "form-group{{ $errors->has('keterangan') ? 'has-error': '' }} ">
        {!! Form::label('keterangan', 'Keterangan', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::textarea('keterangan', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Isi Keterangan'
                ]) !!}
            {!! $errors->first('keterangan', '<p class= "help-block">:message</p>') !!}
            
        </div>
</div>

@if($is_diserahkan > 0)
    <div class= "form-group{{ $errors->has('status') ? 'has-error': '' }} ">
        {!! Form::label('status', 'Status Dokumen', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::select ('status', [ '' => '' ]+
                App\mStatusTujuanDokumen::where('id','>',2)->pluck('description','id')->all(),null,
            [
                'class' => 'js-selectize',
                'placeholder' => 'Pilih Status Dokumen'
            ]) !!}  
            {!! $errors->first('status', '<p class= "help-block">:message</p>') !!}
        </div>
    </div>
@elseif($is_diserahkan == 0)
    <div class= "form-group{{ $errors->has('status') ? 'has-error': '' }} ">
        {!! Form::label('status', 'Status Dokumen', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::select ('status', [ '' => '' ]+
                App\mStatusTujuanDokumen::where('id',2)->pluck('description','id')->all(),null,
            [
                'class' => 'js-selectize',
                'placeholder' => 'Pilih Status Dokumen'
            ]) !!}  
            {!! $errors->first('status', '<p class= "help-block">:message</p>') !!}
        </div>
    </div>
@endif


<div class = "form-group">
    <div class= "col-md-4 col-md-offset-4">
        {!! Form::submit ('Simpan',['class'=>'btn btn-primary']) !!} 
    </div>
</div>

