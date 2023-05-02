<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ImportItem extends DefaultValueBinder implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $data = collect($rows->toArray())->groupBy('item_no')->except('Additional Item');
        $additional_items = collect($rows->toArray())->groupBy('item_no')->only('Additional Item');
        
        foreach($data as $key => $value){
            
            $groupByParentChild = $value->groupBy('type')->toArray();

            if(isset($groupByParentChild['p'][0])){
                $create_arr = collect($groupByParentChild['p'][0])->only(['item_no','link','discipline','legend','description','quantity','units', 'rate'])->toArray();
                
                $item_id = Item::create($create_arr)->id;
                
                if(isset($groupByParentChild['c']) && count($groupByParentChild['c']) > 0){
                    foreach($groupByParentChild['c'] as $child){
                        $child_arr = collect($child)->only(['item_no','link','discipline','legend','description','quantity','units', 'rate'])->toArray();
                        $child_arr['parent_id'] = $item_id;
                        
                        Item::create($child_arr)->id;
                    }

                }
            }   
        }

        if(isset($additional_items['Additional Item'])){
            $temp_arr = [];
            foreach($additional_items['Additional Item'] as $k => $value){
                $add_create_arr = collect($value)->only(['item_no','link','discipline','legend','description','quantity','units', 'rate'])->toArray();
                $add_create_arr['created_at'] = date('Y-m-d h:i:s');
                $temp_arr[] = $add_create_arr;
            }
            Item::insert($temp_arr);
        }
    }
}
