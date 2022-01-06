<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTodo;
use App\Http\Resources\TodoResource;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
  protected $todoservice;

  public function __construct(TodoService $todoservice)
  {
    $this->todoservice = $todoservice;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $todos = $this->todoservice->getTodos();

    return TodoResource::collection($todos);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreUpdateTodo $request)
  {
    $todo = $this->todoservice
      ->createNewTodo($request->validate());

    return new TodoResource($todo);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $todo = $this->todoservice->getTodo($id);

    return new TodoResource($todo);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function update(StoreUpdateTodo $request, $id)
  {
    $this->todoservice
      ->updateTodo($id, $request->validate());

    return response()->json([
      'updated' => true
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Todo  $todo
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->todoservice->deleteTodo($id);

    return response()->json([], 204);
  }
}