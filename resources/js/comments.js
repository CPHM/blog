module.exports = {
    initializeCommentsDrawer: initializeCommentsDrawer,
    openCommentsDrawer: openCommentsDrawer
};

function openCommentsDrawer() {
    const drawer = document.getElementById('commentsDrawer');
    setTimeout(function () {
        drawer.classList.remove('-right-72');
        drawer.classList.add('right-0');
    }, 0);
}

function initializeCommentsDrawer(baseUrl, csrfToken, name = '') {
    const drawer = document.createElement('div');
    drawer.id = 'commentsDrawer';
    drawer.classList.add('fixed', 'top-12', 'bottom-0', '-right-72', 'w-72', 'flex', 'flex-col', 'bg-gray-100', 'dark:bg-gray-800', 'shadow-lg', 'z-10', 'transition-menu');
    document.body.append(drawer);

    const header = document.createElement('div');
    header.classList.add('border-b', 'border-gray-500', 'flex', 'flex-row', 'justify-between', 'item-center', 'p-2')
    drawer.append(header);

    const title = document.createElement('h4');
    title.classList.add('text-2xl');
    title.innerText = 'Comments';
    header.append(title);

    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.classList.add('focus:outline-none', 'text-xl');
    closeBtn.innerHTML = '&#x2716;'
    closeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        setTimeout(function () {
            drawer.classList.remove('right-0');
            drawer.classList.add('-right-72');
        }, 0);
    })
    header.append(closeBtn);

    const scrollable = document.createElement('div');
    scrollable.classList.add('flex-1', 'overflow-y-auto');
    drawer.append(scrollable);

    const commentsContainer = document.createElement('div');
    scrollable.append(commentsContainer);

    const appendFunction = append(commentsContainer);
    const prependFunction = prepend(commentsContainer);

    drawer.append(addCommentForm(baseUrl, csrfToken, prependFunction, name));

    const moreDiv = document.createElement('div');
    moreDiv.classList.add('text-right', 'px-2');
    const moreBtn = document.createElement('button');
    moreBtn.classList.add('link', 'focus:outline-none');
    moreBtn.innerText = 'more';
    moreBtn.clickHandler = function (e) {
        e.preventDefault();
    }
    moreBtn.addEventListener('click', function (e) {
        moreBtn.clickHandler(e);
    });
    moreDiv.append(moreBtn);
    scrollable.append(moreDiv);

    fetchComments(baseUrl, appendFunction, moreBtn)
}

function addCommentForm(url, csrfToken, prepend, name = '') {
    //<form>
    const addComment = document.createElement('form');
    addComment.classList.add('h-48', 'p-1', 'border-t', 'border-gray-500');

    //<input type=text name=name required/>
    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.name = 'name';
    nameInput.required = true;
    nameInput.placeholder = 'Your name';
    nameInput.value = name;
    nameInput.classList.add('w-full', 'mb-2')
    addComment.append(nameInput);

    //<textarea name=content required></textarea>
    const commentBody = document.createElement('textarea');
    commentBody.required = true;
    commentBody.name = 'content';
    commentBody.placeholder = 'Your comment';
    commentBody.rows = 3;
    commentBody.classList.add('w-full', 'resize-none', 'mb-1');
    addComment.append(commentBody);

    //<button type=submit>Send</button>
    const sendButton = document.createElement('button');
    sendButton.type = 'submit';
    sendButton.innerText = 'Send';
    sendButton.classList.add('btn', 'w-full')
    addComment.append(sendButton)

    addComment.addEventListener('submit', function (event) {
        event.preventDefault();
        const data = new FormData(addComment);
        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF_TOKEN': csrfToken
            },
            body: data
        }).then(result => result.json())
            .then(data => {
                prepend(data);
            });
    });

    return addComment;
}

function append(commentsContainer) {
    return function (commentObject) {
        commentsContainer.append(commentCard(commentObject))
    }
}

function prepend(commentsContainer) {
    return function (commentObject) {
        commentsContainer.prepend(commentCard(commentObject))
    }
}

function fetchComments(url, appendFunction, moreBtn) {
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    }).then(result => result.json())
        .then(data => {
            for (const comment of data.data)
                appendFunction(comment);
            if (data.next_page_url) {
                moreBtn.clickHandler = function (e) {
                    e.preventDefault();
                    fetchComments(data.next_page_url, appendFunction, moreBtn);
                };
            } else {
                moreBtn.innerText = "";
                moreBtn.classList.remove('link');
                moreBtn.classList.add('cursor-text')
                moreBtn.clickHandler = function (e) {
                    e.preventDefault();
                };
            }
        });
}

function commentCard(commentObject) {
    console.log(commentObject)

    const card = document.createElement('div');
    card.classList.add('bg-white', 'dark:bg-gray-700', 'm-2', 'p-1', 'shadow')

    const title = document.createElement('h5');
    title.classList.add('text-lg', 'font-roboto');
    title.innerText = commentObject.name;
    card.append(title);

    const content = document.createElement('div');
    content.classList.add('font-lobster', 'justify-text');
    content.innerText = commentObject.content;
    card.append(content);
    console.log(content)

    const created = document.createElement('div');
    created.classList.add('text-xs', 'text-right', 'mt-2');
    created.innerText = new Date(commentObject.created_at).toDateString();
    card.append(created);

    return card;
}
