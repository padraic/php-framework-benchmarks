class HelloController < ApplicationController
  def world
    render :layout => false
  end

end

