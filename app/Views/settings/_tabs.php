<div class="sidebar-tabs">
    <ul class="nav">
        <li class="nav-item <?= $activeTab == 'edit_profile' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings"); ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002-.071.035-.02.004-.014-.004-.071-.036c-.01-.003-.019 0-.024.006l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113-.014.002-.184.093-.01.01-.003.011.018.43.005.012.008.008.201.092c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.003-.011.018-.43-.003-.012-.01-.01-.184-.092Z"/>
                            <path fill="#333333"
                                  d="M18.884 14.469a1 1 0 0 1 1.784.896l-.052.104-.335.58a3.016 3.016 0 0 1 .482.782l.066.169h.671a1 1 0 0 1 .117 1.993L21.5 19h-.671a3 3 0 0 1-.41.776l-.138.174.335.581a1 1 0 0 1-1.668 1.098l-.064-.098-.335-.58c-.293.054-.59.063-.88.03l-.217-.032-.336.582a1 1 0 0 1-1.784-.896l.052-.104.335-.581a3.026 3.026 0 0 1-.482-.78l-.066-.17H14.5a1 1 0 0 1-.117-1.993L14.5 17h.672a3 3 0 0 1 .41-.776l.137-.174-.335-.581a1 1 0 0 1 1.668-1.098l.064.098.335.58c.293-.054.59-.063.88-.03l.217.031.336-.581ZM11 13c.447 0 .887.024 1.316.07a1 1 0 0 1-.211 1.989C11.745 15.02 11.375 15 11 15c-2.023 0-3.843.59-5.136 1.379-.647.394-1.135.822-1.45 1.222-.324.41-.414.72-.414.899 0 .122.037.251.255.426.249.2.682.407 1.344.582C6.917 19.858 8.811 20 11 20l.658-.005a1 1 0 0 1 .027 2L11 22c-2.229 0-4.335-.14-5.913-.558-.785-.208-1.524-.506-2.084-.956C2.41 20.01 2 19.345 2 18.5c0-.787.358-1.523.844-2.139.494-.625 1.177-1.2 1.978-1.69C6.425 13.695 8.605 13 11 13Zm7 4a1 1 0 1 0 0 2 1 1 0 0 0 0-2ZM11 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/>
                        </g>
                    </svg>
                </div>
                <?= trans("update_profile"); ?>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'location' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "location"); ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z"/>
                            <path fill="#333333" d="M12 2a9 9 0 0 1 9 9c0 3.074-1.676 5.59-3.442 7.395a20.441 20.441 0 0 1-2.876 2.416l-.426.29-.2.133-.377.24-.336.205-.416.242a1.874 1.874 0 0 1-1.854 0l-.416-.242-.52-.32-.192-.125-.41-.273a20.638 20.638 0 0 1-3.093-2.566C4.676 16.589 3 14.074 3 11a9 9 0 0 1 9-9Zm0 2a7 7 0 0 0-7 7c0 2.322 1.272 4.36 2.871 5.996a18.03 18.03 0 0 0 2.222 1.91l.458.326c.148.103.29.199.427.288l.39.25.343.209.289.169.455-.269.367-.23c.195-.124.405-.263.627-.417l.458-.326a18.03 18.03 0 0 0 2.222-1.91C17.728 15.361 19 13.322 19 11a7 7 0 0 0-7-7Zm0 3a4 4 0 1 1 0 8 4 4 0 0 1 0-8Zm0 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                        </g>
                    </svg>
                </div>
                <?= trans("location"); ?>
            </a>
        </li>
        <?php if (isSaleActive()): ?>
            <li class="nav-item <?= $activeTab == 'shipping_address' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= generateUrl("settings", "shipping_address"); ?>">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="nonzero">
                                <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z"/>
                                <path fill="#333333" d="M15 4a2 2 0 0 1 2 2v1h1.52a2 2 0 0 1 1.561.75l1.48 1.851a2 2 0 0 1 .439 1.25V15a2 2 0 0 1-2 2 3 3 0 1 1-6 0h-4a3 3 0 1 1-6 0 2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h11ZM7 16a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm10 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2ZM15 6H4v9h.764c.55-.614 1.348-1 2.236-1 .82 0 1.563.33 2.105.862l.131.138h5.528l.115-.121.121-.115V6Zm3.52 3H17v5c.82 0 1.563.33 2.105.862l.131.138H20v-4.15L18.52 9Z"/>
                            </g>
                        </svg>
                    </div>
                    <?= trans("shipping_address"); ?>
                </a>
            </li>
        <?php endif;
        if (authCheck() && user()->is_affiliate == 1 && isSaleActive()): ?>
            <li class="nav-item <?= $activeTab == 'affiliate_links' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= generateUrl("settings", "affiliate_links"); ?>">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g id="link_line" fill="none">
                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z"/>
                                <path fill="#333333" d="M10.232 10.231a5 5 0 0 1 6.89-.172l.181.172 2.828 2.829a5 5 0 0 1-6.89 7.243l-.18-.172-2.122-2.122a1 1 0 0 1 1.32-1.497l.094.083 2.122 2.122a3 3 0 0 0 4.377-4.1l-.135-.143-2.828-2.828a3 3 0 0 0-4.243 0 1 1 0 0 1-1.414-1.415M3.868 3.867a5 5 0 0 1 6.89-.172l.181.172L13.06 5.99a1 1 0 0 1-1.32 1.497l-.094-.083-2.121-2.121A3 3 0 0 0 5.147 9.38l.135.144 2.829 2.829a3 3 0 0 0 4.242 0 1 1 0 1 1 1.415 1.414 5 5 0 0 1-6.89.172l-.182-.172-2.828-2.829a5 5 0 0 1 0-7.07Z"/>
                            </g>
                        </svg>
                    </div>
                    <?= trans("affiliate_links"); ?>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item <?= $activeTab == 'social_media' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "social_media"); ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z"/>
                            <path fill="#333333" d="M18.5 2a3.5 3.5 0 1 1-2.506 5.943L11.67 10.21c.213.555.33 1.16.33 1.79a4.99 4.99 0 0 1-.33 1.79l4.324 2.267a3.5 3.5 0 1 1-.93 1.771l-4.475-2.346a5 5 0 1 1 0-6.963l4.475-2.347A3.5 3.5 0 0 1 18.5 2Zm0 15a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3ZM7 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm11.5-5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z"/>
                        </g>
                    </svg>
                </div>
                <?= trans("social_media"); ?>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'change_password' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "change_password"); ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="nonzero">
                            <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z"/>
                            <path fill="#333333" d="M12 2a6 6 0 0 1 5.996 5.775L18 8h1a2 2 0 0 1 1.995 1.85L21 10v10a2 2 0 0 1-1.85 1.995L19 22H5a2 2 0 0 1-1.995-1.85L3 20V10a2 2 0 0 1 1.85-1.995L5 8h1a6 6 0 0 1 6-6Zm7 8H5v10h14V10Zm-7 2a2 2 0 0 1 1.134 3.647l-.134.085V17a1 1 0 0 1-1.993.117L11 17v-1.268A2 2 0 0 1 12 12Zm0-8a4 4 0 0 0-4 4h8a4 4 0 0 0-4-4Z"/>
                        </g>
                    </svg>
                </div>
                <?= trans("change_password"); ?>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'delete_account' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "delete_account"); ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g id="user_x_line" fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0zM12.594 23.258l-.012.002-.071.035-.02.004-.014-.004-.071-.036c-.01-.003-.019 0-.024.006l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.016-.018m.264-.113-.014.002-.184.093-.01.01-.003.011.018.43.005.012.008.008.201.092c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.003-.011.018-.43-.003-.012-.01-.01z"/>
                            <path fill="#333333" d="M11 4a3 3 0 1 0 0 6 3 3 0 0 0 0-6M6 7a5 5 0 1 1 10 0A5 5 0 0 1 6 7M4.413 17.601c-.323.41-.413.72-.413.899 0 .122.037.251.255.426.249.2.682.407 1.344.582C6.917 19.858 8.811 20 11 20c.222 0 .441-.002.658-.005a1 1 0 0 1 .027 2c-.226.003-.455.005-.685.005-2.229 0-4.335-.14-5.913-.558-.785-.208-1.524-.506-2.084-.956C2.41 20.01 2 19.345 2 18.5c0-.787.358-1.523.844-2.139.494-.625 1.177-1.2 1.978-1.69C6.425 13.695 8.605 13 11 13c.447 0 .887.024 1.316.07a1 1 0 0 1-.211 1.989C11.745 15.02 11.375 15 11 15c-2.023 0-3.843.59-5.136 1.379-.647.394-1.135.822-1.45 1.222Zm12.173-2.43a1 1 0 0 0-1.414 1.415L16.586 18l-1.414 1.414a1 1 0 1 0 1.414 1.414L18 19.414l1.414 1.414a1 1 0 1 0 1.414-1.414L19.414 18l1.414-1.414a1 1 0 0 0-1.414-1.414L18 16.586z"/>
                        </g>
                    </svg>
                </div>
                <?= trans("delete_account"); ?>
            </a>
        </li>
    </ul>
</div>