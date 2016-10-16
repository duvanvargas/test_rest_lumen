<?php
  
namespace App\Http\Controllers;
  
use App\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
  
class ProductoController extends Controller{
  public function index(){
  
        $Productos  = Producto::all();
  
        return response()->json($Productos);
  
    }
  
    public function obtProducto($id){
  
        $producto  = Producto::find($id);
  
        return response()->json($producto);
    }
  
    public function crearProducto(Request $request){
  
        $producto = Producto::create($request->all());
  
        return response()->json($producto);
  
    }
  
    public function borrarProducto($id){
        $producto  = Producto::find($id);
        if ($producto!=NULL) {
        	$producto->delete();
        	$mensaje = array('mensaje' => 'Producto Eliminado');
        }else{
        	$mensaje = array('mensaje' => 'El producto no existe');
        }
 
        return response()->json($mensaje);
    }
  
    public function actualizarProducto(Request $request,$id){
        $producto  = Producto::find($id);
        if ($producto!=NULL) {
        	$producto->nombre = $request->input('nombre');
        	$producto->marca = $request->input('marca');
        	$producto->color = $request->input('color');
        	$producto->save();
        	$mensaje = array('mensaje' => 'Producto Actualizado',$producto);
        }else{
        	$mensaje = array('mensaje' => 'El producto no existe');
        }
        
  
        return response()->json($mensaje);
    }
}
?>