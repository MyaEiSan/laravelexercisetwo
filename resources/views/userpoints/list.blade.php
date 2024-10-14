@foreach ($userpoints as $idx=>$userpoint )
    <tr id="delete_{{$userpoint->id}}">
        <td>
            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$userpoint->id}}" />
        </td>
        <td>{{ ++$idx }}</td>
        <td>{{ $userpoint->students->regnumber }}</td>
        <td>{{ $userpoint->points }}</td>
        <td>{{ $userpoint->created_at->format('d M Y') }}</td>
        <td>{{ $userpoint->updated_at->format('d M Y') }}</td>
        <td>
            <a href="javascript:void(0);" class="text-info edit-btns" data-id="{{$userpoint->id}}"><i class="fas fa-pen"></i></a>
            <a href="javascript:void(0);" class="text-danger delete-btns ms-2" data-id="{{$userpoint->id}}" data-idx="{{$idx+1}}"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr>
@endforeach