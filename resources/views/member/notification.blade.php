<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">My Notifications</h2>
        <p class="text-sm text-gray-300 mt-1">Check your latest notifications and manage them here.</p>
    </div>

    <!-- Unread Notifications -->
    <div class="w-full p-6 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-bell text-blue-500 mr-3"></i>
            Unread Notifications
        </h2>
        <div id="unread-notifications" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
    </div>

    <!-- Read Notifications -->
    <div class="w-full p-6 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            Read Notifications
        </h2>
        <div id="read-notifications" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";

            const typeIcons = {
                property: {
                    icon: 'fa-home',
                    color: 'text-indigo-500',
                    bg: 'bg-indigo-100'
                },
                project: {
                    icon: 'fa-project-diagram',
                    color: 'text-purple-500',
                    bg: 'bg-purple-100'
                },
                membership: {
                    icon: 'fa-file-invoice',
                    color: 'text-yellow-500',
                    bg: 'bg-yellow-100'
                },
                payment: {
                    icon: 'fa-credit-card',
                    color: 'text-green-500',
                    bg: 'bg-green-100'
                },
                profile: {
                    icon: 'fa-user',
                    color: 'text-pink-500',
                    bg: 'bg-pink-100'
                },
                chat: {
                    icon: 'fa-comments',
                    color: 'text-blue-500',
                    bg: 'bg-blue-100'
                },
                review: {
                    icon: 'fa-comment-dots',
                    color: 'text-red-500',
                    bg: 'bg-red-100'
                },
                Default: {
                    icon: 'fa-bell',
                    color: 'text-gray-500',
                    bg: 'bg-gray-100'
                }
            };

            document.addEventListener('DOMContentLoaded', () => {
                fetchNotifications();
            });

            function fetchNotifications() {
                axios.get('/api/notification', {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        renderNotifications(
                            response.data.unread_notifications || [],
                            response.data.read_notifications || []
                        );
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }

            function renderNotifications(unread, read) {
                const unreadContainer = document.getElementById('unread-notifications');
                const readContainer = document.getElementById('read-notifications');

                unreadContainer.innerHTML = '';
                readContainer.innerHTML = '';

                // Helper to create a notification card
                const createCard = (notification, isUnread) => {
                    const type = typeIcons[notification.type] || typeIcons['Default'];
                    const card = document.createElement('div');
                    card.className = `flex items-start space-x-3 p-3 border-l-4 rounded-r-lg cursor-pointer ${
                        isUnread ? 'border-blue-400 bg-blue-50 hover:bg-blue-100' : 'border-green-400 bg-green-50'
                    }`;
                    card.innerHTML = `
                        <div class="w-10 h-10 ${type.bg} rounded-full flex items-center justify-center">
                            <i class="fas ${type.icon} ${type.color}"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold">${notification.title || 'Notification'}</p>
                            <p class="text-gray-700 text-sm mt-1">${notification.message || ''}</p>
                            <p class="text-xs text-gray-400 mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                        </div>
                    `;

                    if (isUnread) {
                        card.addEventListener('click', () => markAsRead(notification.notification_id));
                    } else {
                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'delete-btn text-red-500 hover:text-red-700 ml-4';
                        deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                        deleteBtn.addEventListener('click', e => {
                            e.stopPropagation();
                            deleteNotification(notification.notification_id);
                        });
                        card.appendChild(deleteBtn);
                    }

                    return card;
                };

                // Render unread
                if (!unread.length) {
                    unreadContainer.innerHTML =
                        '<div class="text-gray-500 text-center py-4 col-span-2">No unread notifications</div>';
                } else {
                    unread.forEach(notification => unreadContainer.appendChild(createCard(notification, true)));
                }

                // Render read
                if (!read.length) {
                    readContainer.innerHTML =
                        '<div class="text-gray-500 text-center py-4 col-span-2">No read notifications</div>';
                } else {
                    read.forEach(notification => readContainer.appendChild(createCard(notification, false)));
                }
            }

            function markAsRead(id) {
                axios.put(`/api/notification/${id}`, {}, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(() => fetchNotifications())
                    .catch(err => console.error('Failed to mark as read:', err));
            }

            function deleteNotification(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes'
                }).then(result => {
                    if (result.isConfirmed) {
                        axios.delete(`/api/notification/${id}`, {
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(() => {
                                fetchNotifications();
                                Swal.fire('Deleted!', 'Notification has been deleted.', 'success');
                            })
                            .catch(err => showError('Failed to delete notification.'));
                    }
                });
            }

            // Show messages
            function showSuccess(msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: msg,
                    confirmButtonColor: '#28a745'
                });
            }

            function showError(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#dc3545'
                });
            }
        </script>
    @endpush

</x-app-layout>
