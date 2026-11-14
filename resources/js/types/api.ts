export interface ApiMeta {
  request_id: string;
  timestamp: string;
}

export interface PaginationMeta {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  from: number;
  to: number;
  has_next: boolean;
  has_previous: boolean;
}

export interface ApiResponse<T = any> {
  success: boolean;
  message: string;
  data: T;
  meta: ApiMeta;
}

export interface PaginatedResponse<T = any> {
  success: boolean;
  message: string;
  data: T[];
  meta: ApiMeta & {
    pagination: PaginationMeta;
  };
}

export interface ApiErrorResponse {
  success: false;
  message: string;
  errors?: Record<string, string[]>;
  error_code?: string;
  meta: ApiMeta;
}
