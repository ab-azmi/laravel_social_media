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

export interface Post {
    id: number;
    user: User;
    body: string;
    created_at: string;
    attachments?: null | Array<{
        id: number;
        name: string;
        url: string;
        mime: string;
    }>;
    group?: null | {
        id: number;
        name: string;
    };
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
