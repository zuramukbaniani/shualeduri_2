<a href="{{ route('UserSeeUser', ['id'=>$new->user_id]) }}" class="mr-2"> ავტორი: {{ $new->username }}</a>
<form action="{{ route('ShowPost', ['id'=>$new->id ]) }}" method="post">
                                <a href="{{ route('ShowPost', ['id'=>$new->id ]) }}">{{ $new->title }}
                                </a>
                            </form>
                            <form action="{{ route('UserDeletePost') }}" method="post">