export interface User {
    id: number;
    name: string;
    email: string;
    username: string;
    email_verified_at: string;
    created_at: string;
    updated_at: string;
    cover_path: string;
    avatar_path: string;
}

export interface Attachment {
    id?: number;
    name?: string;
    path: string;
    mime: string;
    size?: number;
    file?: File;
}

export interface Post {
    id: number;
    user: User;
    body: string;
    created_at: string;
    updated_at: string;
    attachments?: null | Array<Attachment>;
    group?: null | {
        id: number;
        name: string;
    };
}

export interface Posts {
    data: Array<Post>;
    links: {
        next: string;
        prev: string;
    };
    meta: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
