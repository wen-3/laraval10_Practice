<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    // 增加此方法 => 當沒有登入會員系統時，會自動跳轉登入會員畫面
    // => 除了 index, show 頁面
    // __construct() => 類似建構子
    public function __construct() {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index() {
        // $articles = Article::all();

        // 將文章列表做反向排序，且每頁只顯示三筆(透過laravel的內建)
        $articles = Article::with('user')->orderBy('id', 'desc')->paginate(5);

        return view('articles.index', ['articles' => $articles]);
    }

    public function show($id){
        $article = Article::find($id);

        return  view('articles.show', ['article' => $article]);
    }

    public function create() {
        return view('articles.create');
    }

    public function store(Request $request) {
        // 驗證欄位是否為我們需要的
        $content = $request->validate([
            'title' => 'required',
            'content' => 'required|min:10'     // 最少需10個字以上
        ]);

        // 透過使用者登入後，所建立的文章內容
        // 如果使用者未登入將無法新增文章
        auth()->user()->articles()->create($content);
        return redirect()->route('root')->with('notice', '文章新增成功');
    }

    public function edit($id) {
        // 此作法只認 id，不認人(誰建立，只能誰編輯) => 所有人都可以編輯
        // $articles = Article::find($id);

        // 只有作者本人才可以編輯，非本人會報錯
        $article = auth()->user()->articles->find($id);

        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, $id){
        $article = auth()->user()->articles->find($id);
        $content = $request->validate([
            'title' => 'required',
            'content' => 'required|min:10'     // 最少需10個字以上
        ]);

        $article->update($content);
        return redirect()->route('root')->with('notice', '文章更新成功');
    }

    // 刪除 - 在這我們使用軟刪除(Article.php)
    public function destroy($id){
        $article = auth()->user()->articles->find($id);
        $article->delete();
        return redirect()->route('root')->with('notice', '文章已刪除!');
    }
}


