<?php

namespace App\Http\Livewire;

use App\Models\Author;
use Livewire\Component;

class AuthorItems extends Component
{

    public $authors ;
    
    public $search_text , $is_search , $type_order , $order;
    protected $listeners = ['reRender'];
    public $orderDirection = 'asc';

    public function changeMessage()
    {
       dd('hi');
    }
    public function destroy($id)
    { 
        
        Author::find($id)->delete();
 
        $this->dispatchBrowserEvent('swal:modal', [

            'type' => 'success',  

        
            'text' => 'تم الحذف',

        ]);
       
 
   }

    public function reRender()
    {

        $this->render();
    }

    public function search() {
        
        $this->is_search = true;
       
    }

    public function toggleSortDirection($type)
    {       $this->type_order = $type;
        $this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
    }
    public function orderBy($type , $order)
    {
       $this->type_order = $type;
       $this->order = $order;
    
    }
    public function render()
    {
       // dd( $this->order);
        if($this->is_search)
        {
            $this->authors = Author::where('name', 'like', '%' . $this->search_text . '%')->get();
        }else{
            if($this->type_order == 'name')
            {
                $this->authors = Author::orderBy('name' ,  $this->orderDirection)->get();
            }if($this->type_order == 'work')
            {
                $this->authors = Author::orderBy('work' ,  $this->orderDirection)->get();
            }else{
                $this->authors = Author::orderBy('name' ,  $this->orderDirection)->get();
            }
            
        }
       

        return view('livewire.author-items');
    }
}
