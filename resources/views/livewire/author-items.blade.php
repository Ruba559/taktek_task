
<div>
    <div class="d-flex flex-row flex-wrap">
        <button   onclick="Livewire.emit('openModal', 'author-modal')"  class="btn btn-outline-primary m-3 ">إضافة جديد</button >
          {{-- <a  class="btn btn-outline-primary m-3 " href="{{route('platforms')}}">المنصات</a> --}}
    </div>
   
    <input wire:keyup="search" wire:model="search_text" placeholder="بحث عن كاتب" class="form-control my-2" >
    <table class="table">
        <thead>
          <tr>
            <th scope="col">صورة الكاتب</th>
            <th scope="col" >اسم الكاتب   <span  wire:click="toggleSortDirection('name')"class="fa fa-angle-up"> </span></th>
            <th scope="col" >عمل الكاتب   <span  wire:click="toggleSortDirection('work')"class="fa fa-angle-up"> </span></th>
            <th scope="col">نبذة عن الكاتب</th>
            <th>المنصات</th>
            <th> العمليات</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($authors as $item)
            <tr>
                <td><img 
                    src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/placeholder.png') }}"  width="80px"
                    alt=""></td>
            <th>{{$item->name}}</th>
            <td>{{$item->work}}</td>
            <td>{{$item->summary}}</td>
             <td>@if($item->platforms)
               @foreach ($item->platforms as $item2)
               {{ $item2->name}} 
@endforeach
@endif</td>  
            <td> 
              {{-- <a title="إضافة منصة" wire:click="$emit('openModal', 'platforms-modal' , {author_id: {{$item->id}}})"><span
                class="fa fa-plus "></span></a>--}}
                  <a  
                wire:click="$emit('openModal', 'author-modal' , {author_id: {{$item->id}}})" ><span
                    class="fa fa-edit"></span> </a>
            <button wire:click="destroy({{ $item->id }})"><span
                    class="fa fa-remove "></span></button></td>
          </tr>
            @endforeach
        
     
        </tbody>
      </table>
</div>
