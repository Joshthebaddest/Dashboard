# Use the official PHP image with Apache
FROM php:8.2-apache

# Install required packages
RUN apt-get update && apt-get install -y unzip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app code to container
COPY . /var/www/html

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Set the Apache document root to public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Change Apache port to 10000 for Render
RUN sed -i 's/80/10000/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Optional: Configure .htaccess rules to allow clean URLs
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf

# Expose port expected by Render
EXPOSE 10000
