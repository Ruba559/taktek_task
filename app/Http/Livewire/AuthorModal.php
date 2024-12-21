<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\Author;
use Livewire\WithFileUploads;
use App\Models\Platform;

class AuthorModal extends ModalComponent
{

    use WithFileUploads;

    public $name , $image , $work , $summary , $platforms =[];

    public $author_id , $author , $platformItems ;

    public $isAddPlatform , $url_platform , $name_platform , $image2_platform , $image_platform;

    public $image2 ;
   
    protected $rules = [
        'name' => 'required',
      ];
    
  
    public function updated($propertyName)
    {
      $this->validateOnly($propertyName);
    }


    public function mount()
    {

      

        if($this->author_id)
        {
            
        $this->author = Author::where('id' , $this->author_id)->first();
      
        $this->fill(['name' => $this->author->name , 'work' => $this->author->work , 'summary' => $this->author->summary]);

        $this->image2 =  $this->author->image;   

        $platforms = Platform::where('author_id', $this->author_id)->get();

        foreach ($platforms as $platform) {
       
            $item['image_platform'] = $platform->image;
            $item['name_platform'] = $platform->name;
            $item['url_platform'] = $platform->url;
  
            array_push($this->platforms, json_encode($item));
  
  
          }
        } 

    }


    public function save()
{

    $this->validate();

    if($this->author_id)
    {

        $this->author->update([
            'name' => $this->name,
            'work' => $this->work,
            'summary' => $this->summary,
           
        ]);

        if ($this->image) {
            if ($this->author->image) {
               
                    if (File_exists(public_path() . '/storage/' . $this->author->image)) {
                        unlink(public_path() . '/storage/' . $this->author->image);
                   
                }

                $this->author->update(['image' => $this->storeImage()]);
            } else {

                $this->author->update(['image' => $this->storeImage()]);
            }
        }

        
        $platforms = Platform::where('author_id', $this->author_id)->get();

        foreach ($platforms as $platform) {
            $platform->delete();
        }
        if($this->platforms){
            foreach (json_decode(json_encode($this->platforms), true) as $item) {
    
                Platform::create([
                    'name' => json_decode($item, true)['name_platform'],
                    'url' => json_decode($item, true)['url_platform'],
                    'author_id' => $this->author_id,
                    'image' =>json_decode($item, true)['image_platform'],
                  ]);
                }
            }

    }else{
      $author = Author::create([
            'name' => $this->name,
            'image' => $this->storeImage(),
            'work' => $this->work,
            'summary' => $this->summary,
        ]);
        if($this->platforms){
            foreach (json_decode(json_encode($this->platforms), true) as $item) {
    
                Platform::create([
                    'name' => json_decode($item, true)['name_platform'],
                    'url' => json_decode($item, true)['url_platform'],
                    'author_id' => $author->id,
                    'image' =>json_decode($item, true)['image_platform'],
               
                  ]);
                }
            }
    }

   // $this->emitTo(AuthorItems::class, 'reRender');
    $this->emit('reRender')->to(AuthorItems::class);
    
    $this->closeModal();
}


public function storeImagePlatform()
{
  if (!$this->image_platform) {

    return Null;
  }
  $name = $this->image_platform->store('platforms/', 'public');
  return $name;
}

public function storeImage()
{
  if (!$this->image) {

    return Null;
  }
  $name = $this->image->store('authors/', 'public');
  return $name;
}

public function deleteImage()
{
  
    $this->image = '';
    $this->image2 = '';
  
}

public function addPlatforms()
{
  $this->isAddPlatform = true;
}


   public function postAddPlatform()
  {


    if (count($this->platforms) > 5) {
   
    } else {
     


        $this->validate([
          'name_platform' => 'required',
          'url_platform' => 'required',
        ]);

        $item['name_platform'] = $this->name_platform;
        $item['url_platform'] = $this->url_platform;
        $item['image_platform'] = $this->storeImagePlatform();

        array_push($this->platforms, json_encode($item));

        $this->name_platform = "";
        $this->url_platform = "";
        $this->image_platform = "";
    
      
    }


  } 
  public function removePlatform($index)
  {
   
    unset($this->platforms[$index]);
   
  }


    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
    public static function modalMaxWidth(): string
   {
   return 'md';
   }

    public function render()
    {
        return view('livewire.author-modal');
    }
}
