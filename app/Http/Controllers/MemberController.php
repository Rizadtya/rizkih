<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode_anggota', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $members = $query->latest()->paginate(15);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_anggota' => 'required|unique:members',
            'nama' => 'required|max:100',
            'nis' => 'required|unique:members',
            'kelas' => 'required|max:50',
            'alamat' => 'nullable',
            'no_telepon' => 'nullable|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Member::create($validated);
        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function show(Member $member)
    {
        $member->load('transactions.book');
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'kode_anggota' => 'required|unique:members,kode_anggota,' . $member->id,
            'nama' => 'required|max:100',
            'nis' => 'required|unique:members,nis,' . $member->id,
            'kelas' => 'required|max:50',
            'alamat' => 'nullable',
            'no_telepon' => 'nullable|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $member->update($validated);
        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil diperbarui');
    }

    public function destroy(Member $member)
    {
        if ($member->activeTransactions()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus anggota yang masih memiliki peminjaman aktif');
        }

        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus');
    }
}
