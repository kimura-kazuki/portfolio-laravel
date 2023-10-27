import { User } from '@/@types/models/user';

export interface Product {
    id: number;
    user: User;
    product_category: ProductCategory;
    product_images: ProductImage[];
    title: string;
    body: string;
    youtube_id: string;
    amount: string;
    amount_number_format: string;
    amount_format_integer: string;
    amount_old: string;
    amount_old_number_format: string;
    amount_old_format_integer: string;
    unit: string;
    referrer_reward: number;
    advertising_reward: number;
    comment_from_seller: string;
    comment_from_seller_new_line: string;
    // comment_from_buyer: string;
    comment_for_admin: string;
    approval_status: string;
    display_status: string;
    product_options: ProductOption[];

    is_display_destination: boolean;
}

export interface ProductOption {
    product_id: number;
    name: string;
    is_multiple_select: boolean;
    order: number;
    product_option_details: ProductOptionDetail[];
}

export interface ProductOptionDetail {
    id: number;
    product_option_id: number;
    name: string;
    order: number;
}

export interface ProductCategory {
    name: string;
}

export interface ProductImage {
    image_path: string;
    image_path_by_environment: string;
    order: string;
    comment: string;
}
