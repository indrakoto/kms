<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Menampilkan semua thread
    public function index()
    {
        $threads = Thread::with(['user', 'replies'])
                    ->withCount('replies')
                    ->latest()
                    ->paginate(10);
                    
        $topContributors = User::whereHas('threads')
            ->withCount('threads')
            ->orderByDesc('threads_count')
            ->limit(5)
            ->get();

        return view('forum.index', compact('threads', 'topContributors'));
    }

    // Simpan thread baru
    public function storeThread(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Thread::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('forum.index')->with('success', 'Thread berhasil dibuat!');
    }

    // Menampilkan satu thread dan semua reply
    public function show(Thread $thread)
    {
        $thread->load(['user', 'replies.user'])
               ->loadCount('replies');
        
        $replies = $thread->replies()
                    ->with('user')
                    ->latest()
                    ->paginate(10);
        
        $topContributors = User::withCount('threads')
                            ->orderBy('threads_count', 'desc')
                            ->limit(5)
                            ->get();
        
        return view('forum.show', compact('thread', 'replies', 'topContributors'));
    }

    public function storeReply(Request $request, Thread $thread)
    {
        // Validasi dan simpan reply
        $validated = $request->validate([
            'content' => 'required|string|min:3'
        ]);
        
        $thread->replies()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);
        
        return back()->with('success', 'Reply posted successfully!');
    }
    public function tambah()
    {
        // Kembali ke view form tambah artikel thread
        return view('forum.tambah'); 
        // Pastikan Anda sudah membuat view ini di resources/views/forum/tambah.blade.php
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Simpan data thread baru
        $thread = Thread::create([
            'user_id' => Auth::id(),  // ambil user yang sedang login
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        // Redirect ke halaman thread yang baru dibuat (bisa disesuaikan)
        // Misalnya kita redirect ke halaman detail thread
        return redirect()->route('forum.threads.show', $thread->id)
                         ->with('success', 'Artikel/forum berhasil ditambahkan!');
    }
}
