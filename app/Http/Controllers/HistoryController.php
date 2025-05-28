<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        // Only the first 50 latest changes
        $histories = History::with('user')->latest()->paginate(50);

        return response()->json($histories);
    }

    public function show($id)
    {
        $history = History::with('user')->findOrFail($id);
        return response()->json($history);
    }
}
