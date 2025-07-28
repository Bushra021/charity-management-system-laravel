<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function create()
    {
        return view('post.create'); // صفحة الفورم
    }

    /**
     * تخزين منشور جديد
     */
    public function store(Request $request)
    {
        // ✅ التحقق من صحة البيانات
        $request->validate([
            'type' => 'required|in:news,event,donation',
            'post' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:50000', // أو رابط
            'video_link' => 'nullable|url'
        ],[
                'type.required' => 'يرجى اختيار نوع المنشور.',
                'type.in' => 'نوع المنشور غير صالح.',
                'post.required' => 'يرجى كتابة محتوى المنشور.',
                'photo.image' => 'يجب أن يكون الملف صورة.',
                'photo.mimes' => 'صيغة الصورة يجب أن تكون: jpeg، png، jpg، gif.',
                'photo.max' => 'أقصى حجم مسموح للصورة هو 2 ميجابايت.',
                'video.file' => 'يجب أن يكون الفيديو ملفًا.',
                'video.mimetypes' => 'صيغة الفيديو غير مدعومة، الصيغ المسموحة: mp4، webm، ogg.',
                'video.max' => 'أقصى حجم مسموح للفيديو هو 20 ميجابايت.',
                'video_link.url' => 'رابط الفيديو غير صالح.'
        ]);

        // ✅ رفع الصورة
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('posts/photos', 'public');
        }

        // ✅ التعامل مع الفيديو
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('posts/videos', 'public');
        } elseif ($request->filled('video_link')) {
            $videoPath = $request->video_link;
        }

        // ✅ إنشاء المنشور
        Post::create([
            'type' => $request->type,
            'post' => $request->post,
            'photo' => $photoPath,
            'video' => $videoPath,
            'user_id' => Auth::id(),
            'active' => 1
        ]);
       // dd($request->all());
        return redirect()->route('posts.create')->with('success', 'تم إنشاء المنشور بنجاح.');
    }

    /**
     * عرض جميع المنشورات (مثال)
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('post.index', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('post.edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:news,event,donation',
            'post' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:50000',
            'video_link' => 'nullable|url'
        ], [
            'type.required' => 'يرجى اختيار نوع المنشور.',
            'type.in' => 'نوع المنشور غير صالح.',
            'post.required' => 'يرجى كتابة محتوى المنشور.',
            'photo.image' => 'يجب أن يكون الملف صورة.',
            'photo.mimes' => 'صيغة الصورة يجب أن تكون: jpeg، png، jpg، gif.',
            'photo.max' => 'أقصى حجم مسموح للصورة هو 2 ميجابايت.',
            'video.file' => 'يجب أن يكون الفيديو ملفًا.',
            'video.mimetypes' => 'صيغة الفيديو غير مدعومة، الصيغ المسموحة: mp4، webm، ogg.',
            'video.max' => 'أقصى حجم مسموح للفيديو هو 20 ميجابايت.',
            'video_link.url' => 'رابط الفيديو غير صالح.'
        ]);


        $post = Post::findOrFail($id);

        // ✅ تحديث الصورة (إن وُجدت)
        if ($request->hasFile('photo')) {
            $post->photo = $request->file('photo')->store('posts/photos', 'public');
        }

        // ✅ تحديث الفيديو
        if ($request->hasFile('video')) {
            $post->video = $request->file('video')->store('posts/videos', 'public');
        } elseif ($request->filled('video_link')) {
            $post->video = $request->video_link;
        }

        $post->type = $request->type;
        $post->post = $request->post;
        $post->save();

        return redirect()->route('posts.create')->with('success', 'تم تحديث المنشور بنجاح.');
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.create')->with('success', 'تم حذف المنشور بنجاح.');
    }
    public function toggleActive($id)
    {
        $post = Post::findOrFail($id);
        $post->active = !$post->active;
        $post->save();

        return redirect()->route('posts.create')->with('success', 'تم تحديث حالة المنشور.');
    }

    public function welcome()
    {

        $newsPosts = Post::where('type', 'news')->where('active', 1)->latest()->get();
       // $events=Post::where('type', 'event')->where('active', 1)->latest()->get();


        return view('welcome', compact('newsPosts'));
    }

    public function donation(){
        $donations=Post::where('type', 'donation')->where('active', 1)->latest()->get();
        return view('post.donation', compact('donations'));
    }

    public function show($id)
    {
        $donation = Post::findOrFail($id);
        return view('post.show', compact('donation'));
    }

    public function event()
    {
        $achievements=Post::where('type', 'event')->where('active', 1)->latest()->get();
        return view('post.event', compact('achievements'));

    }

}
