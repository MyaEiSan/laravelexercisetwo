@foreach ($pointtransferhistories as $idx=>$pointtransferhistory )
    <tr id="delete_{{$pointtransferhistory->id}}">
        <td>
            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$pointtransferhistory->id}}" />
        </td>
        <td>{{ ++$idx }}</td>
        <td>{{ $pointtransferhistory->students->regnumber }}</td>
        <td>{{ $pointtransferhistory->points }}</td>
        <td><span class="badge {{ $pointtransferhistory->accounttype == 'debit'?'text-bg-success':'text-bg-danger'}}">{{ $pointtransferhistory->accounttype }}</span></td>
        <td>{{ $pointtransferhistory->created_at->format('d M Y h:m:s') }}</td>
        <td>{{ $pointtransferhistory->updated_at->format('d M Y h:m:s') }}</td>
        <td>
            <a href="javascript:void(0);" class="text-info edit-btns" data-id="{{$pointtransferhistory->id}}"><i class="fas fa-pen"></i></a>
            <a href="javascript:void(0);" class="text-danger delete-btns ms-2" data-id="{{$pointtransferhistory->id}}" data-idx="{{$idx+1}}"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr>
@endforeach