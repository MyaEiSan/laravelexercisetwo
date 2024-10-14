@foreach ($packages as $idx=>$package )
    <tr id="delete_{{$package->id}}">
        
        <td>
            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$package->id}}" />
        </td>
        <td>{{ $idx++ }}</td>
        <td>{{ $package->name }}</td>
        <td>{{ $package->price }}</td>
        <td>{{ $package->duration }}</td>
        <td>{{ $package->created_at->format('d M Y') }}</td>
        <td>{{ $package->updated_at->format('d M Y') }}</td>
        <td>
            <a href="javascript:void(0);" class="text-info edit-btns" data-id="{{$package->id}}"><i class="fas fa-pen"></i></a>
            <a href="javascript:void(0);" class="text-danger delete-btns ms-2" data-id="{{$package->id}}" data-idx="{{$idx+1}}"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr>
@endforeach