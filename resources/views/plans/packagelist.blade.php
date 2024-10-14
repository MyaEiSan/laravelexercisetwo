@foreach ($packages as $package)
<div class="col-lg-2 col-md-3 mb-3">
    <div class="card rounded-0 border-0 {{$userdata->package_id === $package->id ? "shadow": ''}} plans">
        <div class="card-body">

            <div class="">
                <h6>{{$package->name}}</h6>
                <h5>{{$package->price}}</h5>
            </div>

            <ul class="list-group list-group-flush mb-3">
                @if ($userdata->package_id === $package->id)
                    <li class="list-group-item">Status: Current Plan</li>
                    <li class="list-group-item">Expires: {{ \Carbon\Carbon::parse($userdata->subscription_expires_at)->format('d M Y')}}</li>
                @else
                    <li class="list-group-item">Count: {{$package->duration}} days</li>
                    <li class="list-group-item">Expires: {{now()->addDays($package->duration)->format('d M Y')}} days</li>
                @endif
                
            </ul>

            <div class="text-center">
                <button type="button" class="btn btn-sm {{$userdata->package_id === $package->id?'btn-secondary disabled':'btn-primary'}} rounded-0 add-to-cart" data-package-id="{{$package->id}}" data-package-price="{{$package->price}}">Add Cart</button>
            </div>

        </div>
    </div>
</div>
@endforeach