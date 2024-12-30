<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class NavNotification extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = [
        'notificationUpdated' => 'handleNotificationUpdated'
    ];

    public function mount()
    {
        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();
    }

    public function handleNotificationUpdated()
    {
        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();
    }

    public function getNotifications()
    {
        return Notification::where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', Auth::user()::class)
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getUnreadCount()
    {
        return Notification::where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', Auth::user()::class)
            ->whereNull('read_at')
            ->count();
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        // dd($notification);
        if ($notification) {
            $notification->update(['read_at' => now()]);

            Toaster::success('Notifikasi ditandai telah dibaca.');
        }

        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();

        $this->dispatch('notificationUpdated');
    }

    public function markAllAsRead()
    {
        $notification =  Notification::where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', Auth::user()::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();

        $this->dispatch('notificationUpdated');
    }

    public function delete($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->delete();
            Toaster::success('Notifikasi berhasil dihapus.');
        }

        $this->notifications = $this->getNotifications();
        $this->unreadCount = $this->getUnreadCount();

        $this->dispatch('notificationUpdated');
    }

    public function render()
    {
        return view('livewire.components.nav-notification', [
            'notifications' => $this->notifications,
            'unread_count' => $this->unreadCount
        ]);
    }
}
