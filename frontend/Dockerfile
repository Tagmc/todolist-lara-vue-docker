FROM node:18

# Set thư mục làm việc trong container
WORKDIR /app

# Copy file package trước để cache npm install
COPY package*.json ./

# Cài đặt dependencies
RUN npm install

# Copy phần còn lại của project
COPY . .

# Mở cổng 5173 (vite)
EXPOSE 5173

# Chạy ở chế độ development
CMD ["npm", "run", "dev", "--", "--host"]