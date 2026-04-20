import mongoose from 'mongoose';

const productSchema = new mongoose.Schema({
  sku: {
    type: String,
    unique: true,
    required: true,
    trim: true,
    match: /^[A-Z0-9-]+$/
  },

  name: {
    type: String,
    required: true,
    trim: true,
    minlength: 2
  },

  description: {
    type: String,
    required: true,
    maxlength: 500
  },

  price: {
    type: Number,
    required: true,
    min: 0
  },

  stock: {
    type: Number,
    required: true,
    min: 0
  },

  image: {
    type: String, 
    default: 'default.jpg'
  },

  category: {
    type: String,
    required: true,
    enum: ['pelicula', 'serie', 'documental'] 
  }

}, { timestamps: true });

export const Product = mongoose.model('Product', productSchema);