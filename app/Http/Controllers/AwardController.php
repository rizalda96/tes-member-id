<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;

class AwardController extends Controller
{
  protected $award;

  public function __construct(Award $award)
  {
    $this->award = $award;
  }

  public function search(Request $request)
  {
    $query = $this->award->orderBy($request->sort_by, $request->sort_desc);

    if ($request->has('search')) {
      $filters = collect(json_decode($request->search));
      $type = collect($filters['selected']);
      if (count($type) > 0) {
        $query = $query->where(function ($q) use ($type) {
          $type->map(function ($item, $key) use ($q){
            $q->orWhere('type', $item);
          });
        });
      }


      if ($filters['poin'] > 0) {
        $query = $query->where('poin', '<=', $filters['poin']);
      }
    }

    return $query->paginate($request->limit);
  }
}
